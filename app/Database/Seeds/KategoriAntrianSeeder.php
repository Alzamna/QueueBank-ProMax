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
                'warna' => '#007bff',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Customer Service',
                'prefix' => 'C',
                'deskripsi' => 'Layanan customer service untuk informasi dan konsultasi',
                'warna' => '#28a745',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Prioritas',
                'prefix' => 'P',
                'deskripsi' => 'Layanan prioritas untuk nasabah prioritas',
                'warna' => '#ffc107',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kategori_antrians')->insertBatch($data);
    }
}
