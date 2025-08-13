<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['username', 'password', 'role', 'nama_lengkap', 'email'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,petugas]',
        'nama_lengkap' => 'required|max_length[100]',
        'email' => 'permit_empty|valid_email|max_length[100]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan'
        ]
    ];

    protected $skipValidation = false;
}
