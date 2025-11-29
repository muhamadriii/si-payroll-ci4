<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SalaryDeductionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => $this->uuid(), 'name' => 'Sakit', 'amount' => 50000],
            ['id' => $this->uuid(), 'name' => 'Alfa', 'amount' => 100000],
            ['id' => $this->uuid(), 'name' => 'Izin', 'amount' => 25000],
        ];
        $this->db->table('salary_deductions')->insertBatch($data);
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

