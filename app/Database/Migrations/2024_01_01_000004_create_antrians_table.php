<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAntriansTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nomor_antrian' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'kategori_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'loket_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'petugas_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['menunggu', 'dipanggil', 'selesai', 'lewati'],
                'default' => 'menunggu',
            ],
            'waktu_ambil' => [
                'type' => 'DATETIME',
            ],
            'waktu_panggil' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kategori_id', 'kategori_antrians', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('loket_id', 'lokets', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('petugas_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('antrians');
    }

    public function down()
    {
        $this->forge->dropTable('antrians');
    }
}
