<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalaries extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'user_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'position_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'employee_number' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'position_name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'month' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'year' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'base_salary' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'transport_allowance' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'meal_allowance' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'deduction_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'total_salary' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['user_id','month','year']);
        $this->forge->createTable('salaries', true);

        $this->db->query('ALTER TABLE salaries ADD CONSTRAINT fk_salaries_users FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->db->query('ALTER TABLE salaries ADD CONSTRAINT fk_salaries_positions FOREIGN KEY (position_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE RESTRICT');
    }

    public function down()
    {
        $this->forge->dropTable('salaries', true);
    }
}

