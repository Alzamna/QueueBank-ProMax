<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeviceInfoToAntrians extends Migration
{
    public function up()
    {
        $this->forge->addColumn('antrians', [
            'device_type' => [
                'type' => 'ENUM',
                'constraint' => ['desktop', 'mobile'],
                'default' => 'desktop',
                'after' => 'waktu_ambil'
            ],
            'device_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'device_type'
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'device_id'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'after' => 'user_agent'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('antrians', ['device_type', 'device_id', 'user_agent', 'ip_address']);
    }
}
