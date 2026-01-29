<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use App\Models\JadwalLapanganModel;
use App\Models\RiwayatReservasiModel;

class Reservasi extends BaseController
{
    protected $reservasiModel;
    protected $jadwalModel;
    protected $lapangan;
    protected $reservasi;
    protected $riwayatReservasi;
    protected $userModel;
    protected $lapanganModel;
    
    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->jadwalModel = new JadwalLapanganModel(); 
        $this->reservasi = new ReservasiModel();
        $this->riwayatReservasi = new RiwayatReservasiModel();
        $this->userModel = new \App\Models\UserModel();
        $this->lapanganModel = new \App\Models\LapanganModel();
    }

    public function index()
    {
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d');
        $data = [
            'title' => 'Data Reservasi',
            'reservasi' => $this->reservasiModel->getReservasiAdmin($tanggal),
            'tanggal' => $tanggal
        ];
        return view('admin/reservasi/index', $data);
    }

    public function history()
    {
        $year = $this->request->getGet('year');
        $month = $this->request->getGet('month');

        // Set defaults to current year and month if not provided
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $query = $this->riwayatReservasi;

        $startDate = $year . '-' . $month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month
        $query = $query->where('tanggal >=', $startDate)
                      ->where('tanggal <=', $endDate);

        $data = [
            'title' => 'Riwayat Reservasi',
            'riwayat' => $query->findAll(),
            'year' => $year,
            'month' => $month
        ];
        return view('admin/reservasi/history', $data);
    }

    public function printHistory()
    {
        $year = $this->request->getGet('year');
        $month = $this->request->getGet('month');

        $query = $this->riwayatReservasi;

        if ($year && $month) {
            $startDate = $year . '-' . $month . '-01';
            $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month
            $query = $query->where('tanggal >=', $startDate)
                          ->where('tanggal <=', $endDate);
        }

        $riwayat = $query->findAll();

        $periode = 'Semua Periode';
        if ($year && $month) {
            $periode = 'Bulan: ' . date('F Y', strtotime($year . '-' . $month . '-01'));
        }

        // Calculate total pendapatan
        $totalPendapatan = 0;
        foreach ($riwayat as $r) {
            $totalPendapatan += $r['total_harga'];
        }

        $data = [
            'riwayat' => $riwayat,
            'periode' => $periode,
            'totalPendapatan' => $totalPendapatan
        ];

        // Generate HTML content
        $html = view('admin/reservasi/print_history', $data);

        // Initialize Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the generated PDF
        $dompdf->stream('laporan_riwayat_reservasi.pdf', array('Attachment' => 0));
    }

    public function updateStatus($id, $status)
    {
        $reservasi = $this->reservasiModel->find($id);

        if (!$reservasi) {
            return redirect()->back()->with('error', 'Reservasi tidak ditemukan');
        }

        // Update status reservasi
        $this->reservasiModel->update($id, [
            'status' => $status
        ]);

        // Handle riwayat reservasi
        if ($status === 'selesai') {
            // Fetch additional data
            $user = $this->userModel->find($reservasi['id_user']);
            $lapangan = $this->lapanganModel->find($reservasi['id_lapangan']);

            // Check if record exists
            $existing = $this->riwayatReservasi->where('id_reservasi', $id)->first();

            $dataRiwayat = [
                'id_reservasi' => $id,
                'id_user' => $reservasi['id_user'],
                'nama_user' => $user['nama'],
                'id_lapangan' => $reservasi['id_lapangan'],
                'nama_lapangan' => $lapangan['nama_lapangan'],
                'tanggal' => $reservasi['tanggal'],
                'jam_mulai' => $reservasi['jam_mulai'],
                'jam_selesai' => $reservasi['jam_selesai'],
                'harga_per_jam' => $lapangan['harga_per_jam'],
                'total_harga' => $reservasi['total_harga'],
                'status' => $status
            ];

            if ($existing) {
                $this->riwayatReservasi->update($existing['id_riwayat'], $dataRiwayat);
            } else {
                $this->riwayatReservasi->insert($dataRiwayat);
            }
        } else {
            // Delete from riwayat if exists
            $this->riwayatReservasi->where('id_reservasi', $id)->delete();
        }

        // Query jadwal sesuai reservasi
        $jadwalQuery = $this->jadwalModel
            ->where('id_lapangan', $reservasi['id_lapangan'])
            ->where('tanggal', $reservasi['tanggal'])
            ->where('jam_mulai', $reservasi['jam_mulai']);

        if (in_array($status, ['menunggu', 'dibayar'])) {
            $jadwalQuery->update(null, ['status' => 'dibooking']);
        }

        if ($status === 'dibatalkan') {
            $jadwalQuery->update(null, ['status' => 'tersedia']);
        }

        if ($status === 'selesai') {
            $jadwalQuery->update(null, ['status' => 'selesai']);
        }

        return redirect()->to('/admin/reservasi')
            ->with('success', 'Status reservasi berhasil diperbarui');
    }

}
