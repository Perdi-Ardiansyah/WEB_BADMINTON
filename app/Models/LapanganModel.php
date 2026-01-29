<?php

namespace App\Models;
use CodeIgniter\Model;

class LapanganModel extends Model
{
    protected $table = 'lapangan';
    protected $primaryKey = 'id_lapangan';
    protected $allowedFields = [
        'nama_lapangan',
        'jenis',
        'harga_per_jam',
        'status'
    ];
}
