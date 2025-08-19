<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserKategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2, // petugas1
                'kategori_id' => 1, // Teller
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2, // petugas1
                'kategori_id' => 2, // Customer Service
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Add more staff users and their assigned categories here
            // Example:
            // [
            //     'user_id' => 3, // petugas2
            //     'kategori_id' => 1, // Teller only
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
        ];

        $this->db->table('user_kategori')->insertBatch($data);
    }
}
