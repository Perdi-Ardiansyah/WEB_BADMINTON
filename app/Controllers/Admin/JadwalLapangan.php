<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalLapanganModel;
use App\Models\LapanganModel;

class JadwalLapangan extends BaseController
{
    protected $jadwal;
    protected $lapangan;

    public function __construct()
    {
        $this->jadwal = new JadwalLapanganModel();
        $this->lapangan = new LapanganModel();
    }

    public function index()
    {
        // Auto hapus jadwal kadaluarsa
        $this->hapusJadwalKadaluarsa();

        // Ambil filter
        $id_lapangan = $this->request->getGet('lapangan');
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d');
        $jam = $this->request->getGet('jam');

        $builder = $this->jadwal
            ->select('jadwal_lapangan.*, lapangan.nama_lapangan, reservasi.status as reservasi_status')
            ->join('lapangan', 'lapangan.id_lapangan = jadwal_lapangan.id_lapangan')
            ->join('reservasi', 'reservasi.id_lapangan = jadwal_lapangan.id_lapangan AND reservasi.tanggal = jadwal_lapangan.tanggal AND reservasi.jam_mulai = jadwal_lapangan.jam_mulai', 'left');

        if ($id_lapangan) {
            $builder->where('jadwal_lapangan.id_lapangan', $id_lapangan);
        }

        if ($tanggal) {
            $builder->where('jadwal_lapangan.tanggal', $tanggal);
        }

        if ($jam) {
            $builder->where('jadwal_lapangan.jam_mulai', $jam);
        }

        $data['jadwal'] = $builder
            ->orderBy('tanggal', 'DESC')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        $data['lapangan'] = $this->lapangan->findAll();

        return view('admin/jadwal_lapangan/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_lapangan' => 'required|is_natural_no_zero',
            'tanggal' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();

        $id_lapangan = $this->request->getPost('id_lapangan');
        $tanggal = $this->request->getPost('tanggal');

        // 2️⃣ Validasi status lapangan
        $lapangan = $db->table('lapangan')
            ->where('id_lapangan', $id_lapangan)
            ->get()
            ->getRowArray();

        if (!$lapangan) {
            return redirect()->back()
                ->with('error', 'Lapangan tidak ditemukan.');
        }

        if ($lapangan['status'] !== 'aktif') {
            return redirect()->back()
                ->with('error', 'Lapangan nonaktif, jadwal tidak dapat dibuat.');
        }

        // 3️⃣ Jam operasional
        $jamMulai = 8;
        $jamAkhir = 22;

        $berhasil = 0;

        for ($jam = $jamMulai; $jam < $jamAkhir; $jam++) {

            $mulai = sprintf('%02d:00:00', $jam);
            $selesai = sprintf('%02d:00:00', $jam + 1);

            // 4️⃣ Cegah duplikasi jadwal
            $cek = $this->jadwal
                ->where('id_lapangan', $id_lapangan)
                ->where('tanggal', $tanggal)
                ->where('jam_mulai', $mulai)
                ->first();

            if (!$cek) {
                $this->jadwal->insert([
                    'id_lapangan' => $id_lapangan,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $mulai,
                    'jam_selesai' => $selesai,
                    'status' => 'tersedia'
                ]);
                $berhasil++;
            }
        }

        // 5️⃣ Feedback hasil
        if ($berhasil === 0) {
            return redirect()->back()
                ->with('warning', 'Semua jadwal pada tanggal tersebut sudah tersedia.');
        }

        return redirect()->to('admin/jadwal-lapangan')
            ->with('success', "Berhasil membuat {$berhasil} jadwal (08.00–22.00)");
    }

    public function delete($id)
    {
        $jadwal = $this->jadwal->find($id);

        if ($jadwal['status'] == 'dibooking') {
            return redirect()->back()
                ->with('error', 'Jadwal tidak bisa dihapus');
        }

        $this->jadwal->delete($id);
        return redirect()->to('admin/jadwal-lapangan')->with('success', 'Jadwal dihapus');
    }

    private function hapusJadwalKadaluarsa()
    {
        $hariIni = date('Y-m-d');
        $jamSekarang = date('H:i:s');
        $this->jadwal
            ->where('tanggal <', $hariIni)
            ->where('status', 'tersedia')
            ->delete();

        $this->jadwal
            ->where('tanggal <', $hariIni)
            ->update(null, ['status' => 'selesai']);

        $this->jadwal
            ->where('tanggal', $hariIni)
            ->where('jam_selesai <', $jamSekarang)
            ->update(null, ['status' => 'selesai']);
    }

    public function hapusSemua()
    {
        $this->jadwal
            ->whereIn('status', ['tersedia', 'selesai'])
            ->delete();

        return redirect()->back()
            ->with('success', 'Semua jadwal berhasil dihapus');
    }

    public function hapusByTanggal()
    {
        $tanggal = $this->request->getPost('tanggal');

        if (!$tanggal) {
            return redirect()->back()
                ->with('error', 'Tanggal harus dipilih');
        }

        $this->jadwal
            ->where('tanggal', $tanggal)
            ->where('status', 'tersedia')
            ->delete();

        return redirect()->back()
            ->with('success', 'Jadwal tanggal ' . $tanggal . ' berhasil dihapus');
    }


    public function generateSemuaLapangan()
    {
        $tanggal = $this->request->getPost('tanggal');
        $lapangan = $this->lapangan->where('status', 'aktif')->findAll();

        $jamMulai = 8;
        $jamAkhir = 22;

        foreach ($lapangan as $l) {
            for ($jam = $jamMulai; $jam < $jamAkhir; $jam++) {

                $mulai = sprintf('%02d:00:00', $jam);
                $selesai = sprintf('%02d:00:00', $jam + 1);

                $cek = $this->jadwal
                    ->where('id_lapangan', $l['id_lapangan'])
                    ->where('tanggal', $tanggal)
                    ->where('jam_mulai', $mulai)
                    ->first();

                if (!$cek) {
                    $this->jadwal->insert([
                        'id_lapangan' => $l['id_lapangan'],
                        'tanggal' => $tanggal,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai,
                        'status' => 'tersedia'
                    ]);
                }
            }
        }

        return redirect()->back()
            ->with('success', 'Jadwal semua lapangan berhasil dibuat');
    }

    public function generateSatuLapangan()
    {
        $tanggal = $this->request->getPost('tanggal');
        $id_lapangan = $this->request->getPost('id_lapangan');

        if (!$tanggal || !$id_lapangan) {
            return redirect()->back()->with('error', 'Tanggal dan lapangan wajib dipilih');
        }

        $jamMulai = 8;
        $jamAkhir = 22;

        for ($jam = $jamMulai; $jam < $jamAkhir; $jam++) {

            $mulai = sprintf('%02d:00:00', $jam);
            $selesai = sprintf('%02d:00:00', $jam + 1);

            // Cegah duplikasi
            $cek = $this->jadwal
                ->where('id_lapangan', $id_lapangan)
                ->where('tanggal', $tanggal)
                ->where('jam_mulai', $mulai)
                ->first();

            if (!$cek) {
                $this->jadwal->insert([
                    'id_lapangan' => $id_lapangan,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $mulai,
                    'jam_selesai' => $selesai,
                    'status' => 'tersedia'
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Jadwal satu lapangan berhasil dibuat');
    }
}
