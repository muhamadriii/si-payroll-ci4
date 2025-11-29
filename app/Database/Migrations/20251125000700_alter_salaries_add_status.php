<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSalariesAddStatus extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft','approved'],
                'default' => 'draft',
                'after' => 'total_salary',
            ],
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status',
            ],
        ];
        $this->forge->addColumn('salaries', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('salaries', 'approved_at');
        $this->forge->dropColumn('salaries', 'status');
    }
}

