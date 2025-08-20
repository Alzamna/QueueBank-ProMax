<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLoketIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'loket_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'role'
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('loket_id', 'lokets', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        // Remove foreign key first
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY users_loket_id_foreign');
        
        // Remove column
        $this->forge->dropColumn('users', 'loket_id');
    }
}
