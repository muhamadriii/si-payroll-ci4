<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','user_id','month','year','sick_days','leave_days','absent_days'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'user_id' => 'required',
        'month' => 'required|is_natural_no_zero|greater_than_equal_to[1]|less_than_equal_to[12]',
        'year' => 'required|is_natural_no_zero',
        'sick_days' => 'permit_empty|is_natural',
        'leave_days' => 'permit_empty|is_natural',
        'absent_days' => 'permit_empty|is_natural',
    ];
}

