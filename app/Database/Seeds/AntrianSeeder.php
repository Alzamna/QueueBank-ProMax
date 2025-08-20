<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AntrianSeeder extends Seeder
{
    public function run()
    {
        $antrianData = [
            // Antrian untuk kategori Teller (ID: 1)
            [
                'nomor_antrian' => 'A240101001',
                'kategori_id' => 1,
                'loket_id' => null,
                'petugas_id' => null,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d 08:00:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_001',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'ip_address' => '192.168.1.100',
                'waktu_panggil' => null,
                'waktu_selesai' => null,
                'created_at' => date('Y-m-d 08:00:00'),
                'updated_at' => date('Y-m-d 08:00:00')
            ],
            [
                'nomor_antrian' => 'A240101002',
                'kategori_id' => 1,
                'loket_id' => 1,
                'petugas_id' => 2,
                'status' => 'dipanggil',
                'waktu_ambil' => date('Y-m-d 08:05:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_002',
                'user_agent' => 'Mozilla/5.0 (Android; Mobile; rv:68.0)',
                'ip_address' => '192.168.1.101',
                'waktu_panggil' => date('Y-m-d 08:30:00'),
                'waktu_selesai' => null,
                'created_at' => date('Y-m-d 08:05:00'),
                'updated_at' => date('Y-m-d 08:30:00')
            ],
            [
                'nomor_antrian' => 'A240101003',
                'kategori_id' => 1,
                'loket_id' => 1,
                'petugas_id' => 2,
                'status' => 'selesai',
                'waktu_ambil' => date('Y-m-d 08:10:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_003',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'ip_address' => '192.168.1.102',
                'waktu_panggil' => date('Y-m-d 08:35:00'),
                'waktu_selesai' => date('Y-m-d 08:45:00'),
                'created_at' => date('Y-m-d 08:10:00'),
                'updated_at' => date('Y-m-d 08:45:00')
            ],
            [
                'nomor_antrian' => 'A240101004',
                'kategori_id' => 1,
                'loket_id' => 1,
                'petugas_id' => 2,
                'status' => 'lewati',
                'waktu_ambil' => date('Y-m-d 08:15:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_004',
                'user_agent' => 'Mozilla/5.0 (Android; Mobile; rv:68.0)',
                'ip_address' => '192.168.1.103',
                'waktu_panggil' => date('Y-m-d 08:40:00'),
                'waktu_selesai' => date('Y-m-d 08:50:00'),
                'created_at' => date('Y-m-d 08:15:00'),
                'updated_at' => date('Y-m-d 08:50:00')
            ],
            
            // Antrian untuk kategori CS (ID: 2)
            [
                'nomor_antrian' => 'B240101001',
                'kategori_id' => 2,
                'loket_id' => null,
                'petugas_id' => null,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d 08:20:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_005',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'ip_address' => '192.168.1.104',
                'waktu_panggil' => null,
                'waktu_selesai' => null,
                'created_at' => date('Y-m-d 08:20:00'),
                'updated_at' => date('Y-m-d 08:20:00')
            ],
            [
                'nomor_antrian' => 'B240101002',
                'kategori_id' => 2,
                'loket_id' => 2,
                'petugas_id' => 3,
                'status' => 'dipanggil',
                'waktu_ambil' => date('Y-m-d 08:25:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_006',
                'user_agent' => 'Mozilla/5.0 (Android; Mobile; rv:68.0)',
                'ip_address' => '192.168.1.105',
                'waktu_panggil' => date('Y-m-d 08:50:00'),
                'waktu_selesai' => null,
                'created_at' => date('Y-m-d 08:25:00'),
                'updated_at' => date('Y-m-d 08:50:00')
            ],
            [
                'nomor_antrian' => 'B240101003',
                'kategori_id' => 2,
                'loket_id' => 2,
                'petugas_id' => 3,
                'status' => 'selesai',
                'waktu_ambil' => date('Y-m-d 08:30:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_007',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'ip_address' => '192.168.1.106',
                'waktu_panggil' => date('Y-m-d 08:55:00'),
                'waktu_selesai' => date('Y-m-d 09:05:00'),
                'created_at' => date('Y-m-d 08:30:00'),
                'updated_at' => date('Y-m-d 09:05:00')
            ],
            
            // Antrian untuk kategori Prioritas (ID: 3)
            [
                'nomor_antrian' => 'C240101001',
                'kategori_id' => 3,
                'loket_id' => null,
                'petugas_id' => null,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d 08:35:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_008',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'ip_address' => '192.168.1.107',
                'waktu_panggil' => null,
                'waktu_selesai' => null,
                'created_at' => date('Y-m-d 08:35:00'),
                'updated_at' => date('Y-m-d 08:35:00')
            ],
            [
                'nomor_antrian' => 'C240101002',
                'kategori_id' => 3,
                'loket_id' => 3,
                'petugas_id' => 4,
                'status' => 'selesai',
                'waktu_ambil' => date('Y-m-d 08:40:00'),
                'device_type' => 'mobile',
                'device_id' => 'mobile_009',
                'user_agent' => 'Mozilla/5.0 (Android; Mobile; rv:68.0)',
                'ip_address' => '192.168.1.108',
                'waktu_panggil' => date('Y-m-d 09:00:00'),
                'waktu_selesai' => date('Y-m-d 09:10:00'),
                'created_at' => date('Y-m-d 08:40:00'),
                'updated_at' => date('Y-m-d 09:10:00')
            ]
        ];

        // Insert data
        $this->db->table('antrians')->insertBatch($antrianData);
        
        echo "AntrianSeeder: " . count($antrianData) . " antrian records inserted successfully.\n";
    }
}
