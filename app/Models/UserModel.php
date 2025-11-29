<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','position_id','username','password','nin','name','role','gender','hire_date','profile_image'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'username' => 'required|min_length[4]',
        'password' => 'required|min_length[8]',
        'nin' => 'required',
        'name' => 'required',
        'gender' => 'in_list[M,F]',
        'hire_date' => 'valid_date',
    ];
}

