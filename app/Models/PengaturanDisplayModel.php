<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanDisplayModel extends Model
{
    protected $table = 'pengaturan_displays';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['logo', 'warna_tema', 'teks_berjalan', 'suara_panggilan'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'logo' => 'permit_empty|max_length[255]',
        'warna_tema' => 'required|max_length[7]',
        'teks_berjalan' => 'permit_empty|max_length[500]',
        'suara_panggilan' => 'required|boolean',
    ];

    protected $skipValidation = false;
}
