<?php

namespace App\Models;

use CodeIgniter\Model;

class LoketModel extends Model
{
    protected $table = 'lokets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_loket', 'kode_loket', 'warna', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_loket' => 'required|max_length[50]',
        'kode_loket' => 'required|max_length[10]|is_unique[lokets.kode_loket]',
        'warna' => 'required|max_length[7]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'kode_loket' => [
            'is_unique' => 'Kode loket sudah digunakan'
        ]
    ];

    protected $skipValidation = false;
}
