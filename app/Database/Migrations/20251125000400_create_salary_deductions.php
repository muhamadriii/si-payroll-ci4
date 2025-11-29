<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalaryDeductions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('salary_deductions', true);
    }

    public function down()
    {
        $this->forge->dropTable('salary_deductions', true);
    }
}

