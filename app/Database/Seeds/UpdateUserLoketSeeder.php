<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateUserLoketSeeder extends Seeder
{
    public function run()
    {
        // Update existing petugas users with loket assignments
        $userUpdates = [
            // User ID 2 (petugas) -> Loket 1 (Teller)
            [
                'id' => 2,
                'loket_id' => 1
            ],
            // User ID 3 (petugas) -> Loket 2 (CS)
            [
                'id' => 3,
                'loket_id' => 2
            ],
            // User ID 4 (petugas) -> Loket 3 (Prioritas)
            [
                'id' => 4,
                'loket_id' => 3
            ]
        ];

        foreach ($userUpdates as $update) {
            $this->db->table('users')
                ->where('id', $update['id'])
                ->update(['loket_id' => $update['loket_id']]);
        }
        
        echo "UpdateUserLoketSeeder: " . count($userUpdates) . " user loket records updated successfully.\n";
    }
}
