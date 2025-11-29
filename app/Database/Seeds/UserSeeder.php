<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $position = $this->db->table('positions')->get()->getFirstRow('array');
        $pid = $position ? $position['id'] : null;
        $data = [
            [
                'id' => $this->uuid(),
                'position_id' => $pid,
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nin' => '320126030300001',
                'name' => 'Administrator',
                'role' => 'superadmin',
                'gender' => 'M',
                'hire_date' => date('Y-m-d'),
                'profile_image' => null,
            ],
        ];
        $this->db->table('users')->insertBatch($data);
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

