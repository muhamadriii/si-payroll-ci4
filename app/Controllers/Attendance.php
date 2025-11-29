<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AttendanceModel;
use App\Models\UserModel;
use App\Models\PositionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Services\PayrollService;

class Attendance extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Absensi'];
    }

    public function index()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $attModel = new AttendanceModel();
        $rows = [];
        foreach ($users as $u) {
            $att = $attModel->where(['user_id' => $u['id'], 'month' => $month, 'year' => $year])->first();
            $rows[] = [
                'id' => $u['id'],
                'nin' => $u['nin'] ?? '',
                'username' => $u['username'],
                'name' => $u['name'],
                'sick_days' => $att['sick_days'] ?? 0,
                'leave_days' => $att['leave_days'] ?? 0,
                'absent_days' => $att['absent_days'] ?? 0,
            ];
        }
        return view('attendance/index', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year]);
    }

    public function create()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $rows = [];
        foreach ($users as $u) {
            $rows[] = [
                'id' => $u['id'],
                'nin' => $u['nin'] ?? '',
                'username' => $u['username'],
                'name' => $u['name'],
                'sick_days' => 0,
                'leave_days' => 0,
                'absent_days' => 0,
            ];
        }
        return view('attendance/create', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year]);
    }

    public function store()
    {
        $month = (int) ($this->request->getPost('month') ?? date('n'));
        $year = (int) ($this->request->getPost('year') ?? date('Y'));
        $sick = (array) ($this->request->getPost('sick_days') ?? []);
        $leave = (array) ($this->request->getPost('leave_days') ?? []);
        $absent = (array) ($this->request->getPost('absent_days') ?? []);
        $attModel = new AttendanceModel();
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $created = 0; $updated = 0;
        foreach ($users as $u) {
            $uid = $u['id'];
            $data = [
                'user_id' => $uid,
                'month' => $month,
                'year' => $year,
                'sick_days' => (int) ($sick[$uid] ?? 0),
                'leave_days' => (int) ($leave[$uid] ?? 0),
                'absent_days' => (int) ($absent[$uid] ?? 0),
            ];
            $existing = $attModel->where(['user_id' => $uid, 'month' => $month, 'year' => $year])->first();
            if ($existing) {
                $attModel->update($existing['id'], $data);
                $updated++;
            } else {
                $data['id'] = $this->uuid();
                $attModel->insert($data);
                $created++;
            }
        }
        $service = new PayrollService();
        $calc = $service->calculateForPeriod($month, $year);
        return redirect()->to('/attendance?month=' . $month . '&year=' . $year)->with('success', 'Absensi bulan disimpan. Baru: ' . $created . ', Update: ' . $updated . '. Gaji dihitung: Baru ' . ($calc['created'] ?? 0) . ', Update ' . ($calc['updated'] ?? 0));
    }

    public function edit()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $attModel = new AttendanceModel();
        $rows = [];
        foreach ($users as $u) {
            $att = $attModel->where(['user_id' => $u['id'], 'month' => $month, 'year' => $year])->first();
            $rows[] = [
                'id' => $u['id'],
                'nin' => $u['nin'] ?? '',
                'username' => $u['username'],
                'name' => $u['name'],
                'sick_days' => $att['sick_days'] ?? 0,
                'leave_days' => $att['leave_days'] ?? 0,
                'absent_days' => $att['absent_days'] ?? 0,
            ];
        }
        return view('attendance/edit', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year]);
    }

    public function update()
    {
        $month = (int) ($this->request->getPost('month') ?? date('n'));
        $year = (int) ($this->request->getPost('year') ?? date('Y'));
        $sick = (array) ($this->request->getPost('sick_days') ?? []);
        $leave = (array) ($this->request->getPost('leave_days') ?? []);
        $absent = (array) ($this->request->getPost('absent_days') ?? []);
        $attModel = new AttendanceModel();
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $created = 0; $updated = 0;
        foreach ($users as $u) {
            $uid = $u['id'];
            $data = [
                'user_id' => $uid,
                'month' => $month,
                'year' => $year,
                'sick_days' => (int) ($sick[$uid] ?? 0),
                'leave_days' => (int) ($leave[$uid] ?? 0),
                'absent_days' => (int) ($absent[$uid] ?? 0),
            ];
            $existing = $attModel->where(['user_id' => $uid, 'month' => $month, 'year' => $year])->first();
            if ($existing) {
                $attModel->update($existing['id'], $data);
                $updated++;
            } else {
                $data['id'] = $this->uuid();
                $attModel->insert($data);
                $created++;
            }
        }
        $service = new PayrollService();
        $res = $service->recreateForPeriod($month, $year);
        return redirect()->to('/attendance?month=' . $month . '&year=' . $year)->with('success', 'Absensi bulan diperbarui. Baru: ' . $created . ', Update: ' . $updated . '. Gaji dihapus: ' . ($res['deleted'] ?? 0) . ', dibuat ulang: ' . ($res['created'] ?? 0));
    }

    public function report()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $users = (new UserModel())->where('role', 'employee')->orderBy('nin', 'asc')->findAll();
        $positions = (new PositionModel())->findAll();
        $posMap = [];
        foreach ($positions as $p) { $posMap[$p['id']] = $p['name']; }
        $attModel = new AttendanceModel();
        $rows = [];
        foreach ($users as $u) {
            $att = $attModel->where(['user_id' => $u['id'], 'month' => $month, 'year' => $year])->first();
            $rows[] = [
                'nin' => (string) ($u['nin'] ?? ''),
                'name' => (string) ($u['name'] ?? ''),
                'position_name' => (string) ($posMap[$u['position_id']] ?? '-'),
                'sick_days' => (int) ($att['sick_days'] ?? 0),
                'leave_days' => (int) ($att['leave_days'] ?? 0),
                'absent_days' => (int) ($att['absent_days'] ?? 0),
            ];
        }
        return view('attendance/report', $this->shared + ['rows' => $rows, 'month' => $month, 'year' => $year]);
    }

    public function export()
    {
        $month = (int) ($this->request->getGet('month') ?? date('n'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $format = strtolower((string) ($this->request->getGet('format') ?? 'excel'));
        $users = (new UserModel())->where('role', 'employee')->orderBy('nin', 'asc')->findAll();
        $positions = (new PositionModel())->findAll();
        $posMap = [];
        foreach ($positions as $p) { $posMap[$p['id']] = $p['name']; }
        $attModel = new AttendanceModel();
        $rows = [];
        foreach ($users as $u) {
            $att = $attModel->where(['user_id' => $u['id'], 'month' => $month, 'year' => $year])->first();
            $rows[] = [
                'nin' => (string) ($u['nin'] ?? ''),
                'name' => (string) ($u['name'] ?? ''),
                'position_name' => (string) ($posMap[$u['position_id']] ?? '-'),
                'sick_days' => (int) ($att['sick_days'] ?? 0),
                'leave_days' => (int) ($att['leave_days'] ?? 0),
                'absent_days' => (int) ($att['absent_days'] ?? 0),
            ];
        }
        if ($format === 'excel') {
            $html = view('attendance/export_excel', ['rows' => $rows, 'month' => $month, 'year' => $year]);
            $filename = sprintf('attendance_%04d_%02d.xls', $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($html);
        }
        if ($format === 'pdf') {
            $html = view('attendance/export_pdf', ['rows' => $rows, 'month' => $month, 'year' => $year]);
            $options = new Options();
            $options->set('isRemoteEnabled', false);
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $filename = sprintf('attendance_%04d_%02d.pdf', $year, $month);
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'no-store, no-cache')
                ->setBody($pdf);
        }
        return redirect()->to('/attendance/report?month=' . $month . '&year=' . $year)->with('error', 'Format tidak dikenal');
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
