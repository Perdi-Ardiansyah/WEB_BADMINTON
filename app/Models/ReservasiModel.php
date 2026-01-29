<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $allowedFields = [
        'id_user',
        'id_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;

    public function getReservasiAdmin($date = null)
    {
        $query = $this->select('
            reservasi.*,
            users.username,
            lapangan.nama_lapangan
        ')
            ->join('users', 'users.id_user = reservasi.id_user')
            ->join('lapangan', 'lapangan.id_lapangan = reservasi.id_lapangan');

        if ($date) {
            $query->where('reservasi.tanggal', $date);
        }

        return $query->orderBy('reservasi.tanggal', 'DESC')
            ->orderBy('reservasi.jam_mulai', 'DESC')
            ->findAll();
    }

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getReservasiByUser($idUser)
    {
        return $this->select('
            reservasi.*,
            lapangan.nama_lapangan
        ')
            ->join('lapangan', 'lapangan.id_lapangan = reservasi.id_lapangan')
            ->where('reservasi.id_user', $idUser)
            ->orderBy('reservasi.tanggal', 'DESC')
            ->orderBy('reservasi.jam_mulai', 'DESC')
            ->findAll();
    }

    public function deleteOldReservations($days = 3)
    {
        $cutoffDate = date('Y-m-d', strtotime("-{$days} days"));

        // Delete reservations older than the cutoff date
        return $this->where('tanggal <', $cutoffDate)->delete();
    }
}
