<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;

class Dashboard extends BaseController
{
    protected $reservasiModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
    }

    public function index()
    {
        // Validasi login
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        // Ambil semua reservasi user
        $allReservasi = $this->reservasiModel->getReservasiByUser($idUser);

        // Hitung total reservasi
        $totalReservasi = count($allReservasi);

        // Ambil reservasi mendatang (tanggal >= hari ini, status menunggu atau dibayar)
        $upcomingReservasi = array_filter($allReservasi, function($r) {
            return strtotime($r['tanggal']) >= strtotime(date('Y-m-d')) &&
                   in_array($r['status'], ['menunggu', 'dibayar']);
        });

        // Ambil 5 reservasi terbaru
        $recentReservasi = array_slice($allReservasi, 0, 5);

        $data = [
            'title' => 'Dashboard',
            'totalReservasi' => $totalReservasi,
            'upcomingReservasi' => array_values($upcomingReservasi),
            'recentReservasi' => $recentReservasi
        ];

        return view('client/dashboard/index', $data);
    }
}
