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
    protected $allowedFields = ['username', 'password', 'role', 'nama_lengkap', 'email', 'loket_id'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]',
        'role' => 'required|in_list[admin,petugas]',
        'nama_lengkap' => 'required|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'is_unique' => 'Email sudah digunakan'
        ]
    ];

    protected $skipValidation = false;

    // Override validation rules for updates
    public function getValidationRules(array $options = []): array
    {
        $rules = $this->validationRules;
        
        // If updating and password is empty, remove password validation
        if (isset($options['id']) && (!isset($options['password']) || empty($options['password']))) {
            // Password is optional for updates
        } else {
            // Password is required for new users
            $rules['password'] = 'required|min_length[6]';
        }
        
        return $rules;
    }

    /**
     * Get users with related data (loket and kategori)
     */
    public function getUsersWithDetails()
    {
        $users = $this->findAll();
        
        foreach ($users as &$user) {
            // Get loket info for petugas
            if ($user['role'] === 'petugas' && !empty($user['loket_id'])) {
                $loketModel = new \App\Models\LoketModel();
                $user['loket'] = $loketModel->find($user['loket_id']);
            }
            
            // Get kategori info for petugas
            if ($user['role'] === 'petugas') {
                $userKategoriModel = new \App\Models\UserKategoriModel();
                $user['kategori'] = $userKategoriModel->getCategoriesByUserId($user['id']);
            }
        }
        
        return $users;
    }
}
