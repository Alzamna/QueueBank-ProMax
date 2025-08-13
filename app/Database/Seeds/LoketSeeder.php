<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_loket' => 'Teller 1',
                'kode_loket' => 'T1',
                'warna' => '#007bff',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_loket' => 'Teller 2',
                'kode_loket' => 'T2',
                'warna' => '#28a745',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_loket' => 'Customer Service',
                'kode_loket' => 'CS',
                'warna' => '#ffc107',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_loket' => 'Prioritas',
                'kode_loket' => 'PR',
                'warna' => '#dc3545',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('lokets')->insertBatch($data);
    }
}
