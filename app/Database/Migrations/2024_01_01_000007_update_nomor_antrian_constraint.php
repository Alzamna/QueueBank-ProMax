<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateNomorAntrianConstraint extends Migration
{
    public function up()
    {
        // Drop the unique constraint on nomor_antrian
        $this->db->query('ALTER TABLE antrians DROP INDEX nomor_antrian');
        
        // Add unique constraint on combination of nomor_antrian and DATE(waktu_ambil)
        // This ensures uniqueness per day
        $this->db->query('ALTER TABLE antrians ADD UNIQUE KEY unique_nomor_per_day (nomor_antrian, DATE(waktu_ambil))');
    }

    public function down()
    {
        // Drop the new unique constraint
        $this->db->query('ALTER TABLE antrians DROP INDEX unique_nomor_per_day');
        
        // Restore the original unique constraint
        $this->db->query('ALTER TABLE antrians ADD UNIQUE KEY nomor_antrian (nomor_antrian)');
    }
} 