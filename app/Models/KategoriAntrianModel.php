<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriAntrianModel extends Model
{
    protected $table = 'kategori_antrians';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_kategori', 'prefix', 'deskripsi', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kategori' => 'required|max_length[50]',
        'prefix' => 'required|max_length[5]|is_unique[kategori_antrians.prefix]',
        'deskripsi' => 'permit_empty|max_length[500]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'prefix' => [
            'is_unique' => 'Prefix sudah digunakan'
        ]
    ];

    protected $skipValidation = false;
}
