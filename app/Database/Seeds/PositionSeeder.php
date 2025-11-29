<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => $this->uuid(), 'name' => 'Staff', 'base_salary' => 5000000, 'transport_allowance' => 500000, 'meal_allowance' => 300000],
            ['id' => $this->uuid(), 'name' => 'Supervisor', 'base_salary' => 8000000, 'transport_allowance' => 800000, 'meal_allowance' => 500000],
        ];
        $this->db->table('positions')->insertBatch($data);
    }

    private function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        $hex = bin2hex($data);
        return sprintf('%s-%s-%s-%s-%s', substr($hex,0,8), substr($hex,8,4), substr($hex,12,4), substr($hex,16,4), substr($hex,20,12));
    }
}

