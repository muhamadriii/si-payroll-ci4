<?php

namespace App\Services;

use App\Models\UserModel;
use App\Models\PositionModel;
use App\Models\AttendanceModel;
use App\Models\SalaryDeductionModel;
use App\Models\SalaryModel;

class PayrollService
{
    public function calculateForPeriod(int $month, int $year): array
    {
        $users = (new UserModel())->where('role', 'employee')->findAll();
        $positions = (new PositionModel())->findAll();
        $posById = [];
        foreach ($positions as $p) {
            $posById[$p['id']] = $p;
        }
        $dedModel = new SalaryDeductionModel();
        $dedRows = $dedModel->whereIn('name', ['Sakit', 'Izin', 'Alfa'])->findAll();
        $dedMap = [];
        foreach ($dedRows as $d) {
            $dedMap[$d['name']] = (float) $d['amount'];
        }
        $nomSakit = (float) ($dedMap['Sakit'] ?? 0);
        $nomIzin = (float) ($dedMap['Izin'] ?? 0);
        $nomAlfa = (float) ($dedMap['Alfa'] ?? 0);
        $attModel = new AttendanceModel();
        $salModel = new SalaryModel();
        $db = \Config\Database::connect();
        $db->transStart();
        $created = 0; $updated = 0;
        foreach ($users as $u) {
            $uid = $u['id'];
            $posId = $u['position_id'] ?? null;
            if (!$posId || !isset($posById[$posId])) {
                continue;
            }
            $pos = $posById[$posId];
            $att = $attModel->where(['user_id' => $uid, 'month' => $month, 'year' => $year])->first();
            $sick = (int) ($att['sick_days'] ?? 0);
            $leave = (int) ($att['leave_days'] ?? 0);
            $absent = (int) ($att['absent_days'] ?? 0);
            $base = (float) ($pos['base_salary'] ?? 0);
            $transport = (float) ($pos['transport_allowance'] ?? 0);
            $meal = (float) ($pos['meal_allowance'] ?? 0);
            $gross = $base + $transport + $meal;
            $potAbsen = ($sick * $nomSakit) + ($leave * $nomIzin) + ($absent * $nomAlfa);
            $deduction = $potAbsen;
            $total = $gross - $deduction;
            $existing = $salModel->where(['user_id' => $uid, 'month' => $month, 'year' => $year])->first();
            $payload = [
                'user_id' => $uid,
                'position_id' => $posId,
                'nin' => (string) ($u['nin'] ?? ''),
                'position_name' => (string) ($pos['name'] ?? ''),
                'month' => $month,
                'year' => $year,
                'base_salary' => $base,
                'transport_allowance' => $transport,
                'meal_allowance' => $meal,
                'deduction_amount' => $deduction,
                'total_salary' => $total,
                'status' => 'draft',
                'approved_at' => null,
                'locked' => 0,
            ];
            if ($existing) {
                $salModel->update($existing['id'], $payload);
                $updated++;
            } else {
                $payload['id'] = $this->uuid();
                $salModel->insert($payload);
                $created++;
            }
        }
        $db->transComplete();
        return ['created' => $created, 'updated' => $updated];
    }

    public function recreateForPeriod(int $month, int $year): array
    {
        $salModel = new SalaryModel();
        $existingRows = $salModel->where(['month' => $month, 'year' => $year])->findAll();
        $deleted = 0;
        foreach ($existingRows as $row) {
            $salModel->delete($row['id']);
            $deleted++;
        }
        $result = $this->calculateForPeriod($month, $year);
        return ['deleted' => $deleted, 'created' => $result['created'], 'updated' => $result['updated']];
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

