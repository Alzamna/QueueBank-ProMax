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
                'role' => 'admin',
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@bank.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'petugas1',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'role' => 'petugas',
                'nama_lengkap' => 'Petugas Loket 1',
                'email' => 'petugas1@bank.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'petugas2',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'role' => 'petugas',
                'nama_lengkap' => 'Petugas Loket 2',
                'email' => 'petugas2@bank.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
