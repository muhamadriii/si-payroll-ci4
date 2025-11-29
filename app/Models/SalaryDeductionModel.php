<?php

namespace App\Models;

use CodeIgniter\Model;

class SalaryDeductionModel extends Model
{
    protected $table = 'salary_deductions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','name','amount'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'name' => 'required',
        'amount' => 'decimal',
    ];
}

