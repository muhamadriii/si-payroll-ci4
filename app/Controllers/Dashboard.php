<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\SalaryModel;

class Dashboard extends Controller
{
    public function index()
    {
        $users = new UserModel();
        $salaries = new SalaryModel();
        $totalEmployees = $users->countAllResults();
        $month = (int) date('n');
        $year = (int) date('Y');
        $rows = $salaries->where(['month' => $month, 'year' => $year])->findAll();
        $processed = count($rows);
        $totalCost = 0.0;
        foreach ($rows as $r) {
            $totalCost += (float) $r['total_salary'];
        }
        $avgSalary = $processed > 0 ? round($totalCost / $processed, 2) : 0.0;
        return view('dashboard/index', [
            'totalEmployees' => $totalEmployees,
            'processed' => $processed,
            'totalCost' => $totalCost,
            'avgSalary' => $avgSalary,
        ]);
    }
}

