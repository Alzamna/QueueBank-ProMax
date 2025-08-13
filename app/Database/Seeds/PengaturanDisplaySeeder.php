<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanDisplaySeeder extends Seeder
{
    public function run()
    {
        $data = [
            'logo' => '/assets/images/logo-bank.png',
            'warna_tema' => '#f8f9fa',
            'teks_berjalan' => 'Selamat datang di Bank ProMax. Silakan ambil nomor antrian sesuai kebutuhan Anda. Terima kasih atas kunjungan Anda.',
            'suara_panggilan' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('pengaturan_displays')->insert($data);
    }
}
