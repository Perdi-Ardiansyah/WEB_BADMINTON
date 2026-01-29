<?php

namespace App\Controllers;
use App\Models\LapanganModel;
use App\Models\ReservasiModel;

class Lapangan extends BaseController
{
    protected $lapangan;
    protected $reservasi;
    protected $db;

    public function __construct()
    {
        $this->lapangan = new LapanganModel();
        $this->reservasi = new ReservasiModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if (!in_array($role, ['admin'])) {
            return redirect()->to('/unauthorized');
        }

        return view('lapangan/index', [
            'lapangan' => $this->lapangan->findAll()
        ]);
    }

    public function store()
    {
        $this->lapangan->insert([
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis' => $this->request->getPost('jenis'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('/lapangan')->with('success', 'Lapangan berhasil ditambahkan');
    }

    public function update($id)
    {
        $cekReservasi = $this->reservasi
            ->where('id_lapangan', $id)
            ->whereIn('status', ['menunggu', 'dibayar'])
            ->first();

        if ($cekReservasi) {
            return redirect()->to('/lapangan')
                ->with('error', 'Lapangan tidak dapat diedit karena sedang dibooking');
        }

        $this->lapangan->update($id, [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis' => $this->request->getPost('jenis'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/lapangan')
            ->with('success', 'Data lapangan berhasil diperbarui');
    }


    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Cek reservasi yang masih aktif (bukan selesai)
        $reservasiAktif = $db->table('reservasi')
            ->where('id_lapangan', $id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->countAllResults();

        if ($reservasiAktif > 0) {
            return redirect()->back()
                ->with('error', 'Lapangan tidak dapat dihapus karena masih memiliki reservasi yang belum selesai.');
        }

        // Hapus jadwal lapangan terlebih dahulu
        $db->table('jadwal_lapangan')
            ->where('id_lapangan', $id)
            ->delete();

        $db->table('lapangan')
            ->where('id_lapangan', $id)
            ->delete();

        return redirect()->to('/lapangan')
            ->with('success', 'Lapangan berhasil dihapus.');
    }


}
