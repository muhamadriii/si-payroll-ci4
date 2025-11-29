<?php

namespace App\Models;

use CodeIgniter\Model;

class SalaryModel extends Model
{
    protected $table = 'salaries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id','user_id','position_id','nin','position_name','month','year',
        'base_salary','transport_allowance','meal_allowance','deduction_amount','total_salary','status','approved_at','locked'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'user_id' => 'required',
        'position_id' => 'required',
        'nin' => 'required',
        'position_name' => 'required',
        'month' => 'required|is_natural_no_zero|greater_than_equal_to[1]|less_than_equal_to[12]',
        'year' => 'required|is_natural_no_zero',
    ];
}

