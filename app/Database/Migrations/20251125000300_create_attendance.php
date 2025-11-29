<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendance extends Migration
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
            'month' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'year' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'sick_days' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
            ],
            'leave_days' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
            ],
            'absent_days' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addUniqueKey(['user_id', 'month', 'year']);
        $this->forge->createTable('attendance', true);

        $this->db->query('ALTER TABLE attendance ADD CONSTRAINT fk_attendance_users FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('attendance', true);
    }
}

