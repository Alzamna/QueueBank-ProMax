<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriAntrianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Teller',
                'prefix' => 'T',
                'deskripsi' => 'Layanan teller untuk transaksi perbankan',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Customer Service',
                'prefix' => 'C',
                'deskripsi' => 'Layanan customer service untuk informasi dan konsultasi',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Prioritas',
                'prefix' => 'P',
                'deskripsi' => 'Layanan prioritas untuk nasabah prioritas',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kategori_antrians')->insertBatch($data);
    }
}
