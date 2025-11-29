<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','name','base_salary','transport_allowance','meal_allowance'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'base_salary' => 'decimal',
        'transport_allowance' => 'decimal',
        'meal_allowance' => 'decimal',
    ];
}

