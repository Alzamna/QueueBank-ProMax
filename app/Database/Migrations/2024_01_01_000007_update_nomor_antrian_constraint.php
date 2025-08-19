<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateNomorAntrianConstraint extends Migration
{
    public function up()
    {
        // Drop the unique constraint on nomor_antrian if it exists
        try {
            $this->db->query('ALTER TABLE antrians DROP INDEX nomor_antrian');
        } catch (\Exception $e) {
            // Index might not exist, continue
        }
        
        // Add a generated column for date only
        $this->db->query('ALTER TABLE antrians ADD COLUMN tanggal_ambil DATE GENERATED ALWAYS AS (DATE(waktu_ambil)) STORED');
        
        // Add unique constraint on combination of nomor_antrian and tanggal_ambil
        // This ensures uniqueness per day
        $this->db->query('ALTER TABLE antrians ADD UNIQUE KEY unique_nomor_per_day (nomor_antrian, tanggal_ambil)');
    }

    public function down()
    {
        // Drop the new unique constraint
        $this->db->query('ALTER TABLE antrians DROP INDEX unique_nomor_per_day');
        
        // Drop the generated column
        $this->db->query('ALTER TABLE antrians DROP COLUMN tanggal_ambil');
        
        // Restore the original unique constraint
        $this->db->query('ALTER TABLE antrians ADD UNIQUE KEY nomor_antrian (nomor_antrian)');
    }
} 