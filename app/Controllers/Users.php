<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\PositionModel;

class Users extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Pegawai'];
    }
    public function index()
    {
        $rows = (new UserModel())->findAll();
        $positions = (new PositionModel())->findAll();
        $posMap = [];
        foreach ($positions as $p) {
            $posMap[$p['id']] = $p['name'];
        }
        return view('users/index', $this->shared + ['rows' => $rows, 'positionsById' => $posMap]);
    }

    public function create()
    {
        $positions = (new PositionModel())->findAll();
        return view('users/form', $this->shared + ['positions' => $positions, 'mode' => 'create', 'title' => 'Tambah Pegawai']);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['id'] = $this->uuid();
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (isset($data['employee_number'])) {
            $data['nin'] = $data['employee_number'];
            unset($data['employee_number']);
        }
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getClientExtension());
            $allowed = ['jpg','jpeg','png','webp'];
            if (in_array($ext, $allowed, true)) {
                $uploadDir = FCPATH . 'uploads/users';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0777, true);
                }
                $newName = $this->uuid() . '.' . $ext;
                $file->move($uploadDir, $newName);
                $data['profile_image'] = 'uploads/users/' . $newName;
            }
        }
        $model = new UserModel();
        $t = $model->insert($data);
        return redirect()->to('/users')->with('success', 'User created');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }
        $positions = (new PositionModel())->findAll();
        return view('users/form', $this->shared + ['positions' => $positions, 'mode' => 'edit', 'user' => $user, 'title' => 'Edit Pegawai']);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        if (isset($data['employee_number'])) {
            $data['nin'] = $data['employee_number'];
            unset($data['employee_number']);
        }
        $model = new UserModel();
        $existing = $model->find($id);
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getClientExtension());
            $allowed = ['jpg','jpeg','png','webp'];
            if (in_array($ext, $allowed, true)) {
                $uploadDir = FCPATH . 'uploads/users';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0777, true);
                }
                $newName = $this->uuid() . '.' . $ext;
                $file->move($uploadDir, $newName);
                $data['profile_image'] = 'uploads/users/' . $newName;
                if (!empty($existing['profile_image'])) {
                    $oldPath = FCPATH . $existing['profile_image'];
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }
        }
        if (!$model->update($id, $data)) {
            return redirect()->back()->with('error', implode(', ', $model->errors() ?? []));
        }
        return redirect()->to('/users')->with('success', 'User updated');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/users')->with('success', 'User deleted');
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
