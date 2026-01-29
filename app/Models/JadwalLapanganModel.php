<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalLapanganModel extends Model
{
    protected $table      = 'jadwal_lapangan';
    protected $primaryKey = 'id_jadwal';

    protected $allowedFields = [
        'id_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status'
    ];

    protected $useTimestamps = false;
}
