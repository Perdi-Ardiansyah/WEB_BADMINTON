<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use App\Models\UserModel;
use App\Models\LapanganModel;

class Dashboard extends BaseController
{
    protected $reservasiModel;
    protected $userModel;
    protected $lapanganModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->userModel = new UserModel();
        $this->lapanganModel = new LapanganModel();
    }

    public function index()
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Ambil reservasi hari ini
        $todayReservasi = $this->reservasiModel->getReservasiAdmin($today);

        // Hitung statistik hari ini
        $totalReservasi = count($todayReservasi);
        $pendingReservasi = count(array_filter($todayReservasi, function($r) {
            return $r['status'] === 'menunggu';
        }));
        $paidReservasi = count(array_filter($todayReservasi, function($r) {
            return $r['status'] === 'dibayar';
        }));
        $completedReservasi = count(array_filter($todayReservasi, function($r) {
            return $r['status'] === 'selesai';
        }));

        // Hitung total pendapatan hari ini dari reservasi yang dibayar/selesai
        $totalRevenue = 0;
        foreach ($todayReservasi as $r) {
            if (in_array($r['status'], ['dibayar', 'selesai'])) {
                $totalRevenue += $r['total_harga'] ?? 0;
            }
        }

        // Ambil data tambahan (total keseluruhan)
        $totalUsers = $this->userModel->where('role', 'client')->countAllResults();
        $totalLapangan = $this->lapanganModel->countAllResults();

        // Ambil 5 reservasi terbaru hari ini
        $recentReservasi = array_slice($todayReservasi, 0, 5);

        $data = [
            'title' => 'Dashboard Admin',
            'totalReservasi' => $totalReservasi,
            'pendingReservasi' => $pendingReservasi,
            'paidReservasi' => $paidReservasi,
            'completedReservasi' => $completedReservasi,
            'totalRevenue' => $totalRevenue,
            'totalUsers' => $totalUsers,
            'totalLapangan' => $totalLapangan,
            'recentReservasi' => $recentReservasi
        ];

        return view('admin/dashboard/index', $data);
    }
}
