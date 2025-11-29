<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SalaryModel;
use App\Services\PayrollService;
use Dompdf\Dompdf;
use Dompdf\Options;

class Salaries extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Data Gaji'];
    }

    public function index()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $rows = (new SalaryModel())->where(['month' => $month, 'year' => $year])->findAll();
        return view('salaries/index', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year]);
    }

    public function report()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $rows = (new SalaryModel())
            ->where(['month' => $month, 'year' => $year])
            ->orderBy('nin', 'asc')
            ->findAll();
        $sumBase = 0.0; $sumTrans = 0.0; $sumMeal = 0.0; $sumDeduct = 0.0; $sumTotal = 0.0;
        foreach ($rows as $r) {
            $sumBase += (float) ($r['base_salary'] ?? 0);
            $sumTrans += (float) ($r['transport_allowance'] ?? 0);
            $sumMeal += (float) ($r['meal_allowance'] ?? 0);
            $sumDeduct += (float) ($r['deduction_amount'] ?? 0);
            $sumTotal += (float) ($r['total_salary'] ?? 0);
        }
        $stats = [
            'count' => count($rows),
            'sumBase' => $sumBase,
            'sumTrans' => $sumTrans,
            'sumMeal' => $sumMeal,
            'sumDeduct' => $sumDeduct,
            'sumTotal' => $sumTotal,
            'generatedAt' => date('d/m/Y H:i'),
        ];
        return view('salaries/report', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year, 'stats' => $stats]);
    }

    public function slipReport()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $date = (string) ($this->request->getGet('date') ?? date('Y-m-d'));
        $users = (new \App\Models\UserModel())
            ->where('role', 'employee')
            ->orderBy('name', 'asc')
            ->findAll();
        $selectedUserId = (string) ($this->request->getGet('user_id') ?? '');
        return view('salaries/slip_report', $this->shared + [
            'users' => $users,
            'month' => $month,
            'year' => $year,
            'date' => $date,
            'selectedUserId' => $selectedUserId,
        ]);
    }

    public function slipExport()
    {
        $userId = (string) ($this->request->getGet('user_id') ?? '');
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $printDate = (string) ($this->request->getGet('date') ?? date('Y-m-d'));
        $format = strtolower((string) ($this->request->getGet('format') ?? 'pdf'));

        if ($userId === '') {
            return redirect()->back()->with('error', 'Pilih pegawai terlebih dahulu');
        }

        $row = (new SalaryModel())->where(['user_id' => $userId, 'month' => $month, 'year' => $year])->first();
        if (!$row) {
            return redirect()->to('/salaries/slip-report?month=' . $month . '&year=' . $year)->with('error', 'Data gaji tidak ditemukan untuk pegawai tersebut');
        }
        $user = (new \App\Models\UserModel())->find($row['user_id']);
        $att = (new \App\Models\AttendanceModel())->where(['user_id' => $row['user_id'], 'month' => (int) $row['month'], 'year' => (int) $row['year']])->first();
        $dedRows = (new \App\Models\SalaryDeductionModel())->whereIn('name', ['Sakit', 'Izin', 'Alfa'])->findAll();
        $map = [];
        foreach ($dedRows as $d) { $map[$d['name']] = (float) $d['amount']; }
        $sick = (int) ($att['sick_days'] ?? 0);
        $leave = (int) ($att['leave_days'] ?? 0);
        $absent = (int) ($att['absent_days'] ?? 0);
        $nomSakit = (float) ($map['Sakit'] ?? 0);
        $nomIzin = (float) ($map['Izin'] ?? 0);
        $nomAlfa = (float) ($map['Alfa'] ?? 0);
        $deductionDetail = [
            'sakit' => ['days' => $sick, 'nominal' => $nomSakit, 'amount' => $sick * $nomSakit],
            'izin' => ['days' => $leave, 'nominal' => $nomIzin, 'amount' => $leave * $nomIzin],
            'alfa' => ['days' => $absent, 'nominal' => $nomAlfa, 'amount' => $absent * $nomAlfa],
        ];
        $deductionDetail['total'] = ($deductionDetail['sakit']['amount'] + $deductionDetail['izin']['amount'] + $deductionDetail['alfa']['amount']);

        if ($format === 'excel') {
            $html = view('salaries/slip_export_excel', ['row' => $row, 'user' => $user, 'att' => $att, 'deductionDetail' => $deductionDetail, 'printDate' => $printDate]);
            $filename = sprintf('slip_%s_%04d_%02d.xls', (string) ($user['nin'] ?? 'pegawai'), $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($html);
        }

        if ($format === 'pdf') {
            $html = view('salaries/slip_export_pdf', ['row' => $row, 'user' => $user, 'att' => $att, 'deductionDetail' => $deductionDetail, 'printDate' => $printDate]);
            $options = new Options();
            $options->set('isRemoteEnabled', false);
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $filename = sprintf('slip_%s_%04d_%02d.pdf', (string) ($user['nin'] ?? 'pegawai'), $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($pdf);
        }

        return redirect()->to('/salaries/slip-report?month=' . $month . '&year=' . $year)->with('error', 'Format tidak dikenal');
    }

    public function calculate()
    {
        $role = strtolower((string) (session()->get('role') ?? 'employee'));
        if ($role !== 'superadmin') {
            return redirect()->back()->with('error', 'Anda tidak berhak melakukan kalkulasi gaji');
        }
        $month = (int) ($this->request->getPost('month') ?? date('n'));
        $year = (int) ($this->request->getPost('year') ?? date('Y'));

        $service = new PayrollService();
        $res = $service->calculateForPeriod($month, $year);
        return redirect()->to('/salaries?month=' . $month . '&year=' . $year)
            ->with('success', 'Kalkulasi selesai. Baru: ' . ($res['created'] ?? 0) . ', Update: ' . ($res['updated'] ?? 0));
    }

    public function slip($id)
    {
        $row = (new SalaryModel())->find($id);
        if (!$row) {
            return redirect()->to('/salaries')->with('error', 'Data gaji tidak ditemukan');
        }
        $user = (new \App\Models\UserModel())->find($row['user_id']);
        $att = (new \App\Models\AttendanceModel())->where(['user_id' => $row['user_id'], 'month' => (int) $row['month'], 'year' => (int) $row['year']])->first();
        $dedRows = (new \App\Models\SalaryDeductionModel())->whereIn('name', ['Sakit', 'Izin', 'Alfa'])->findAll();
        $map = [];
        foreach ($dedRows as $d) { $map[$d['name']] = (float) $d['amount']; }
        $sick = (int) ($att['sick_days'] ?? 0);
        $leave = (int) ($att['leave_days'] ?? 0);
        $absent = (int) ($att['absent_days'] ?? 0);
        $nomSakit = (float) ($map['Sakit'] ?? 0);
        $nomIzin = (float) ($map['Izin'] ?? 0);
        $nomAlfa = (float) ($map['Alfa'] ?? 0);
        $deductionDetail = [
            'sakit' => ['days' => $sick, 'nominal' => $nomSakit, 'amount' => $sick * $nomSakit],
            'izin' => ['days' => $leave, 'nominal' => $nomIzin, 'amount' => $leave * $nomIzin],
            'alfa' => ['days' => $absent, 'nominal' => $nomAlfa, 'amount' => $absent * $nomAlfa],
        ];
        $deductionDetail['total'] = ($deductionDetail['sakit']['amount'] + $deductionDetail['izin']['amount'] + $deductionDetail['alfa']['amount']);
        return view('salaries/slip', ['row' => $row, 'user' => $user, 'att' => $att, 'deductionDetail' => $deductionDetail]);
    }

    public function export()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $format = strtolower((string) ($this->request->getGet('format') ?? 'csv'));
        $rows = (new SalaryModel())
            ->where(['month' => $month, 'year' => $year])
            ->orderBy('nin', 'asc')
            ->findAll();

        if ($format === 'excel') {
            $html = view('salaries/export_excel', ['rows' => $rows, 'month' => $month, 'year' => $year]);
            $filename = sprintf('salaries_%04d_%02d.xls', $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($html);
        }

        if ($format === 'pdf') {
            $html = view('salaries/export_pdf', ['rows' => $rows, 'month' => $month, 'year' => $year]);
            $options = new Options();
            $options->set('isRemoteEnabled', false);
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $filename = sprintf('salaries_%04d_%02d.pdf', $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($pdf);
        }

        $filename = sprintf('salaries_%04d_%02d.csv', $year, $month);
        $header = ['NIN','Jabatan','Gaji Pokok','Tunjangan Transport','Tunjangan Makan','Potongan','Total','Bulan','Tahun'];
        $out = "\xEF\xBB\xBF";
        $out .= implode(',', $header) . "\r\n";
        foreach ($rows as $r) {
            $line = [
                $r['nin'] ?? '',
                $r['position_name'] ?? '',
                number_format((float) ($r['base_salary'] ?? 0), 2, '.', ''),
                number_format((float) ($r['transport_allowance'] ?? 0), 2, '.', ''),
                number_format((float) ($r['meal_allowance'] ?? 0), 2, '.', ''),
                number_format((float) ($r['deduction_amount'] ?? 0), 2, '.', ''),
                number_format((float) ($r['total_salary'] ?? 0), 2, '.', ''),
                (int) ($r['month'] ?? $month),
                (int) ($r['year'] ?? $year),
            ];
            $escaped = array_map(function($v) {
                $s = (string) $v;
                if (strpbrk($s, ",\"\n\r") !== false) {
                    $s = '"' . str_replace('"', '""', $s) . '"';
                }
                return $s;
            }, $line);
            $out .= implode(',', $escaped) . "\r\n";
        }

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'no-store, no-cache')
            ->setBody($out);
    }

    private function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        $hex = bin2hex($data);
        return sprintf('%s-%s-%s-%s-%s', substr($hex,0,8), substr($hex,8,4), substr($hex,12,4), substr($hex,16,4), substr($hex,20,12));
    }
}
