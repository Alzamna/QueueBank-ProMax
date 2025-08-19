<?php

namespace App\Models;

use CodeIgniter\Model;

class UserKategoriModel extends Model
{
    protected $table = 'user_kategori';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'kategori_id'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'kategori_id' => 'required|integer',
    ];

    protected $skipValidation = false;

    /**
     * Get categories for a specific user
     */
    public function getCategoriesByUserId($userId)
    {
        return $this->select('kategori_antrians.*')
                    ->join('kategori_antrians', 'kategori_antrians.id = user_kategori.kategori_id')
                    ->where('user_kategori.user_id', $userId)
                    ->findAll();
    }

    /**
     * Get users for a specific category
     */
    public function getUsersByKategoriId($kategoriId)
    {
        return $this->select('users.*')
                    ->join('users', 'users.id = user_kategori.user_id')
                    ->where('user_kategori.kategori_id', $kategoriId)
                    ->findAll();
    }

    /**
     * Assign categories to user
     */
    public function assignCategoriesToUser($userId, $kategoriIds)
    {
        // Delete existing assignments
        $this->where('user_id', $userId)->delete();
        
        // Insert new assignments
        $data = [];
        foreach ($kategoriIds as $kategoriId) {
            $data[] = [
                'user_id' => $userId,
                'kategori_id' => $kategoriId
            ];
        }
        
        if (!empty($data)) {
            return $this->insertBatch($data);
        }
        
        return true;
    }

    /**
     * Get all user-kategori assignments with user and kategori details
     */
    public function getAllUserKategori()
    {
        return $this->select('
                user_kategori.*,
                users.username,
                users.nama_lengkap,
                users.role,
                kategori_antrians.nama_kategori,
                kategori_antrians.prefix
            ')
            ->join('users', 'users.id = user_kategori.user_id')
            ->join('kategori_antrians', 'kategori_antrians.id = user_kategori.kategori_id')
            ->orderBy('users.username', 'ASC')
            ->orderBy('kategori_antrians.nama_kategori', 'ASC')
            ->findAll();
    }
}
