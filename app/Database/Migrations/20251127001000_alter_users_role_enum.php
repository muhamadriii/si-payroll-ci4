<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersRoleEnum extends Migration
{
    public function up()
    {
        // Map existing roles to new set before altering ENUM
        $this->db->query('UPDATE users SET role="superadmin" WHERE LOWER(role) IN ("admin","superadmin")');
        $this->db->query('UPDATE users SET role="employee" WHERE role IS NULL OR LOWER(role) IN ("employee","hr","finance")');

        // Alter ENUM to only employee and superadmin, default employee (lowercase)
        $this->db->query('ALTER TABLE users MODIFY COLUMN role ENUM("employee","superadmin") NOT NULL DEFAULT "employee" AFTER name');
    }

    public function down()
    {
        // Revert values to previous set
        $this->db->query('UPDATE users SET role="Admin" WHERE role="superadmin"');
        $this->db->query('UPDATE users SET role="Employee" WHERE role IS NULL OR role="employee"');

        // Restore previous ENUM set
        $this->db->query('ALTER TABLE users MODIFY COLUMN role ENUM("Admin","HR","Finance","Employee") NOT NULL DEFAULT "Employee" AFTER name');
    }
}

