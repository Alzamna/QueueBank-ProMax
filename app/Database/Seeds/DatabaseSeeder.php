<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('LoketSeeder');
        $this->call('KategoriAntrianSeeder');
        $this->call('PengaturanDisplaySeeder');
    }
}
