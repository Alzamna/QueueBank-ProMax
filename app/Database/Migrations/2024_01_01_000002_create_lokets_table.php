<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoketsTable extends Migration
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
            'nama_loket' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'kode_loket' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true,
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => '#007bff',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif',
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
        $this->forge->createTable('lokets');
    }

    public function down()
    {
        $this->forge->dropTable('lokets');
    }
}
