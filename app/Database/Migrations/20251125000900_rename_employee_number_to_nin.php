<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameEmployeeNumberToNin extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE users CHANGE employee_number nin VARCHAR(64) NOT NULL');
        $this->db->query('ALTER TABLE salaries CHANGE employee_number nin VARCHAR(64) NOT NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE users CHANGE nin employee_number VARCHAR(64) NOT NULL');
        $this->db->query('ALTER TABLE salaries CHANGE nin employee_number VARCHAR(64) NOT NULL');
    }
}

