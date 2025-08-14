<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_loket' => 'Loket 1',
                'kode_loket' => 'L1',
                'warna' => '#007bff',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_loket' => 'Loket 2',
                'kode_loket' => 'L2',
                'warna' => '#28a745',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_loket' => 'Loket 3',
                'kode_loket' => 'L3',
                'warna' => '#ffc107',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('lokets')->insertBatch($data);
    }
}
