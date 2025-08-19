<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserKategoriTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kategori_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kategori_id', 'kategori_antrians', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['user_id', 'kategori_id']);
        $this->forge->createTable('user_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('user_kategori');
    }
}
