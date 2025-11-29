<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PositionSeeder::class);
        $this->call(SalaryDeductionSeeder::class);
        $this->call(UserSeeder::class);
    }
}

