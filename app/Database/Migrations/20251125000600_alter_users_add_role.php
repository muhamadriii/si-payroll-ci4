<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddRole extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Admin','HR','Finance','Employee'],
                'default' => 'Employee',
                'after' => 'name',
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role');
    }
}

