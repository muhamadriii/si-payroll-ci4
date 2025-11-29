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
        $sumBase = 0.0; $sumTrans = 0.0; $sumMeal = 0.0; $sumDeduct = 0.0;
        foreach ($rows as $r) {
            $totalCost += (float) $r['total_salary'];
            $sumBase += (float) ($r['base_salary'] ?? 0);
            $sumTrans += (float) ($r['transport_allowance'] ?? 0);
            $sumMeal += (float) ($r['meal_allowance'] ?? 0);
            $sumDeduct += (float) ($r['deduction_amount'] ?? 0);
        }
        $avgSalary = $processed > 0 ? round($totalCost / $processed, 2) : 0.0;

        $monthsMap = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $barLabels = [];
        $barData = [];
        for ($m = 1; $m <= $month; $m++) {
            $label = ($monthsMap[$m] ?? (string) $m) . ' ' . $year;
            $barLabels[] = $label;
            $sum = (float) ($salaries->select('SUM(total_salary) as s')->where(['month' => $m, 'year' => $year])->first()['s'] ?? 0);
            $barData[] = round($sum, 2);
        }

        $compLabels = ['Gaji Pokok', 'Tunjangan Transport', 'Tunjangan Makan', 'Potongan'];
        $compData = [round($sumBase,2), round($sumTrans,2), round($sumMeal,2), round($sumDeduct,2)];

        return view('dashboard/index', [
            'totalEmployees' => $totalEmployees,
            'processed' => $processed,
            'totalCost' => $totalCost,
            'avgSalary' => $avgSalary,
            'barLabels' => $barLabels,
            'barData' => $barData,
            'compLabels' => $compLabels,
            'compData' => $compData,
        ]);
    }
}

