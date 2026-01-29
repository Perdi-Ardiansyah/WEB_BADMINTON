<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use App\Models\RiwayatReservasiModel;

class Laporan extends BaseController
{
    protected $reservasi;
    protected $riwayatReservasi;

    public function __construct()
    {
        $this->reservasi = new ReservasiModel();
        $this->riwayatReservasi = new RiwayatReservasiModel();
    }

    public function harian()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $data['tanggal'] = $tanggal;

        $data['riwayat'] = $this->riwayatReservasi
            ->where('tanggal', $tanggal)
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        $total_pendapatan = 0;

        foreach ($data['riwayat'] as &$r) {
            $total_pendapatan += $r['total_harga'];
        }

        $data['total_pendapatan'] = $total_pendapatan;

        return view('admin/laporan/harian', $data);
    }


    public function bulanan()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        // laporan per hari
        $data['laporan'] = $this->riwayatReservasi
            ->select("
            tanggal,
            COUNT(id_riwayat) AS total_reservasi,
            SUM(total_harga) AS pendapatan
        ")
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        // 🔥 TOTAL PENDAPATAN BULANAN
        $total = $this->riwayatReservasi
            ->select("SUM(total_harga) AS total_pendapatan")
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->first();

        $data['total_pendapatan'] = $total['total_pendapatan'] ?? 0;
        $data['bulan'] = (int) $bulan;
        $data['tahun'] = (int) $tahun;

        return view('admin/laporan/bulanan', $data);
    }


}
