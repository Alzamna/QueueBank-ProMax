<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@queuebank.com',
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'petugas1',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Petugas 1',
                'email' => 'petugas1@queuebank.com',
                'role' => 'petugas',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
