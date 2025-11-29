<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'position_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'null' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'employee_number' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['M','F'],
            ],
            'hire_date' => [
                'type' => 'DATE',
            ],
            'profile_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('position_id');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('employee_number');
        $this->forge->createTable('users', true);

        $this->db->query('ALTER TABLE users ADD CONSTRAINT fk_users_positions FOREIGN KEY (position_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE SET NULL');
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}

