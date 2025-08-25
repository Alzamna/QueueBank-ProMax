<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarnaToKategoriAntrians extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kategori_antrians', [
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => '#007bff',
                'after' => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kategori_antrians', 'warna');
    }
}
