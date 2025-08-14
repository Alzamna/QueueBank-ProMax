<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanDisplaySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'logo' => 'queuebank-logo.png',
                'warna_tema' => '#667eea',
                'teks_berjalan' => 'Selamat datang di QueueBank ProMax - Sistem Antrian Modern dan Terpercaya',
                'suara_panggilan' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('pengaturan_displays')->insertBatch($data);
    }
}
