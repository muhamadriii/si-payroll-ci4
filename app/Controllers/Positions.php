<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PositionModel;

class Positions extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Jabatan'];
    }

    public function index()
    {
        $rows = (new PositionModel())->findAll();
        return view('positions/index', $this->shared + ['rows' => $rows]);
    }

    public function create()
    {
        return view('positions/form', $this->shared + ['mode' => 'create']);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['id'] = $this->uuid();
        $model = new PositionModel();
        if (!$model->insert($data)) {
            return redirect()->back()->with('error', implode(', ', $model->errors() ?? []));
        }
        return redirect()->to('/positions')->with('success', 'Jabatan ditambahkan');
    }

    public function edit($id)
    {
        $model = new PositionModel();
        $row = $model->find($id);
        if (!$row) {
            return redirect()->to('/positions')->with('error', 'Jabatan tidak ditemukan');
        }
        return view('positions/form', $this->shared + ['mode' => 'edit', 'position' => $row]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $model = new PositionModel();
        if (!$model->update($id, $data)) {
            return redirect()->back()->with('error', implode(', ', $model->errors() ?? []));
        }
        return redirect()->to('/positions')->with('success', 'Jabatan diperbarui');
    }

    public function delete($id)
    {
        $model = new PositionModel();
        $model->delete($id);
        return redirect()->to('/positions')->with('success', 'Jabatan dihapus');
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
