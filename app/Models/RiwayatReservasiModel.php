<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatReservasiModel extends Model
{
    protected $table            = 'riwayat_reservasi';
    protected $primaryKey       = 'id_riwayat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_reservasi',
        'id_user',
        'nama_user',
        'id_lapangan',
        'nama_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'harga_per_jam',
        'total_harga',
        'status',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getReservasiAdmin($date = null)
    {
        $query = $this->select('*, nama_user as username');

        if ($date) {
            $query->where('tanggal', $date);
        }

        return $query->orderBy('tanggal', 'DESC')
            ->orderBy('jam_mulai', 'DESC')
            ->findAll();
    }
}
