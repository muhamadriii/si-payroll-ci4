<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSalariesAddLocked extends Migration
{
    public function up()
    {
        $fields = [
            'locked' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'approved_at',
            ],
        ];
        $this->forge->addColumn('salaries', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('salaries', 'locked');
    }
}

