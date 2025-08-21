<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AntrianModel;

class CleanupAntrian extends BaseCommand
{
    protected $group       = 'QueueBank';
    protected $name        = 'cleanup:antrian';
    protected $description = 'Menghapus semua antrian dari database (untuk dijalankan setiap hari jam 00:00)';

    public function run(array $params)
    {
        $antrianModel = new AntrianModel();
        
        // Hapus semua antrian dari database
        $result = $antrianModel->truncate();
        
        if ($result) {
            CLI::write('✅ Semua antrian berhasil dihapus dari database', 'green');
            CLI::write('📅 Cleanup dilakukan pada: ' . date('Y-m-d H:i:s'), 'yellow');
        } else {
            CLI::error('❌ Gagal menghapus antrian dari database');
        }
    }
}
