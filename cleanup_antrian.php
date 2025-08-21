<?php

/**
 * Script untuk cleanup antrian otomatis
 * Jalankan script ini via cron job setiap hari jam 00:00
 * 
 * Contoh cron job:
 * 0 0 * * * /usr/bin/php /path/to/your/project/cleanup_antrian.php
 */

// Load CodeIgniter
require_once 'vendor/autoload.php';

// Set environment
putenv('CI_ENVIRONMENT=production');

// Load CodeIgniter
$app = require_once 'app/Config/Paths.php';
$paths = new \Config\Paths();

// Load the framework
require_once $paths->systemDirectory . '/bootstrap.php';

// Initialize CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Load database
$db = \Config\Database::connect();

try {
    // Log start of cleanup
    log_message('info', '=== MULAI CLEANUP ANTRIAN OTOMATIS ===');
    log_message('info', 'Waktu: ' . date('Y-m-d H:i:s'));
    
    // Get total antrian before cleanup
    $totalBefore = $db->table('antrians')->countAllResults();
    log_message('info', 'Total antrian sebelum cleanup: ' . $totalBefore);
    
    // Perform cleanup
    $result = $db->table('antrians')->truncate();
    
    if ($result) {
        log_message('info', '✅ Cleanup berhasil dilakukan');
        log_message('info', 'Total antrian yang dihapus: ' . $totalBefore);
        
        // Send notification (optional)
        // You can add email notification or other notification methods here
        
        echo "SUCCESS: Cleanup antrian berhasil dilakukan pada " . date('Y-m-d H:i:s') . "\n";
        echo "Total antrian yang dihapus: " . $totalBefore . "\n";
    } else {
        log_message('error', '❌ Gagal melakukan cleanup antrian');
        echo "ERROR: Gagal melakukan cleanup antrian\n";
        exit(1);
    }
    
    log_message('info', '=== SELESAI CLEANUP ANTRIAN OTOMATIS ===');
    
} catch (Exception $e) {
    log_message('error', 'Exception saat cleanup: ' . $e->getMessage());
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
