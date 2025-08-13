<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanDisplaysTable extends Migration
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
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'warna_tema' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => '#f8f9fa',
            ],
            'teks_berjalan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'suara_panggilan' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->createTable('pengaturan_displays');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_displays');
    }
}
