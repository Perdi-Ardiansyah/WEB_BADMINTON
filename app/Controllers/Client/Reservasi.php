<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use App\Models\JadwalLapanganModel;
use App\Models\LapanganModel;
use App\Models\RiwayatReservasiModel;


class Reservasi extends BaseController
{
    protected $jadwal;
    protected $lapangan;
    protected $reservasi;
    protected $riwayatReservasi;

    public function __construct()
    {
        $this->jadwal = new JadwalLapanganModel();
        $this->lapangan = new LapanganModel();
        $this->reservasi = new ReservasiModel();
        $this->riwayatReservasi = new RiwayatReservasiModel();
    }

    public function index()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $idLap = $this->request->getGet('lapangan');

        // 🔹 Ambil semua lapangan (untuk filter dropdown)
        $lapanganModel = new \App\Models\LapanganModel();
        $lapangan = $lapanganModel->findAll();

        // 🔹 Query jadwal
        $builder = $this->jadwal
            ->select('jadwal_lapangan.*, lapangan.nama_lapangan')
            ->join('lapangan', 'lapangan.id_lapangan = jadwal_lapangan.id_lapangan')
            ->where('jadwal_lapangan.tanggal', $tanggal);

        if ($idLap) {
            $builder->where('jadwal_lapangan.id_lapangan', $idLap);
        }

        $data = [
            'tanggal' => $tanggal,   // ✅
            'lapangan' => $lapangan,  // ✅ INI YANG KURANG
            'jadwal' => $builder
                ->orderBy('jadwal_lapangan.jam_mulai', 'ASC')
                ->findAll(),
        ];

        return view('client/reservasi/index', $data);
    }

    public function store()
    {
        // 1. validasi input
        if (
            !$this->validate([
                'id_jadwal' => 'required|numeric'
            ])
        ) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // 2. validasi login
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        $idJadwal = $this->request->getPost('id_jadwal');
        $jadwal = $this->jadwal->find($idJadwal);

        // 3. validasi jadwal
        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan');
        }

        if ($jadwal['status'] !== 'tersedia') {
            return redirect()->back()->with('error', 'Jadwal sudah dibooking');
        }

        // 3.5. ambil data lapangan untuk harga
        $lapangan = $this->lapangan->find($jadwal['id_lapangan']);
        $start = strtotime($jadwal['jam_mulai']);
        $end = strtotime($jadwal['jam_selesai']);
        $hours = ($end - $start) / 3600;
        $total_harga = $lapangan['harga_per_jam'];

        // 4. validasi double booking user
        $exists = $this->reservasi
            ->where('id_user', $idUser)
            ->where('id_lapangan', $jadwal['id_lapangan'])
            ->where('tanggal', $jadwal['tanggal'])
            ->where('jam_mulai', $jadwal['jam_mulai'])
            ->whereIn('status', ['menunggu', 'dibayar'])
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Reservasi sudah ada');
        }

        // 5. simpan reservasi
        $idReservasi = $this->reservasi->insert([
            'id_user' => $idUser,
            'id_lapangan' => $jadwal['id_lapangan'],
            'tanggal' => $jadwal['tanggal'],
            'jam_mulai' => $jadwal['jam_mulai'],
            'jam_selesai' => $jadwal['jam_selesai'],
            'total_harga' => $total_harga,
            'status' => 'menunggu',
            'created_at' => date('Y-m-d H:i:s')
        ]);



        // 7. update jadwal
        $this->jadwal->update($idJadwal, [
            'status' => 'dibooking'
        ]);

        return redirect()->to('/client/reservasi')
            ->with('success', 'Reservasi berhasil dibuat');
    }

    public function history()
    {
        // 1. validasi login
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        // 2. ambil filter
        $status = $this->request->getGet('status');
        $tanggal = $this->request->getGet('tanggal');

        // 3. query riwayat reservasi
        $builder = $this->riwayatReservasi->where('id_user', $idUser);

        if ($status) {
            $builder->where('status', $status);
        }

        if ($tanggal) {
            $builder->where('tanggal', $tanggal);
        }

        $riwayat = $builder->orderBy('tanggal', 'DESC')->orderBy('jam_mulai', 'DESC')->findAll();

        $data = [
            'title' => 'Riwayat Booking',
            'riwayat' => $riwayat
        ];

        return view('client/reservasi/history', $data);
    }

    public function deleteHistory($id)
    {
        // 1. validasi login
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        // 2. cari riwayat
        $riwayat = $this->riwayatReservasi->find($id);

        if (!$riwayat || $riwayat['id_user'] != $idUser) {
            return redirect()->back()->with('error', 'Riwayat tidak ditemukan');
        }

        // 3. hapus riwayat
        $this->riwayatReservasi->delete($id);

        return redirect()->to('/client/reservasi/history')->with('success', 'Riwayat berhasil dihapus');
    }

}

