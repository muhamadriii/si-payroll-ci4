<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SalaryDeductionModel;

class SalaryDeductions extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Potongan Gaji'];
    }

    public function index()
    {
        $rows = (new SalaryDeductionModel())->findAll();
        return view('deductions/index', $this->shared + ['rows' => $rows]);
    }

    public function create()
    {
        return view('deductions/form', $this->shared + ['mode' => 'create']);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['id'] = $this->uuid();
        $model = new SalaryDeductionModel();
        $data = $model->insert($data);
        return redirect()->to('/deductions')->with('success', 'Potongan ditambahkan');
    }

    public function edit($id)
    {
        $model = new SalaryDeductionModel();
        $row = $model->find($id);
        if (!$row) {
            return redirect()->to('/deductions')->with('error', 'Potongan tidak ditemukan');
        }
        return view('deductions/form', $this->shared + ['mode' => 'edit', 'deduction' => $row]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $model = new SalaryDeductionModel();
        if (!$model->update($id, $data)) {
            return redirect()->back()->with('error', implode(', ', $model->errors() ?? []));
        }
        return redirect()->to('/deductions')->with('success', 'Potongan diperbarui');
    }

    public function delete($id)
    {
        $model = new SalaryDeductionModel();
        $model->delete($id);
        return redirect()->to('/deductions')->with('success', 'Potongan dihapus');
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

