<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Profile extends Controller
{
    protected array $shared = [];

    public function __construct()
    {
        $this->shared = ['title' => 'Profil'];
    }

    public function index()
    {
        $uid = session()->get('user_id');
        if (!$uid) {
            return redirect()->to('/login');
        }
        $model = new UserModel();
        $user = $model->find($uid);
        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'User tidak ditemukan');
        }
        return view('profile/index', $this->shared + ['user' => $user]);
    }

    public function update()
    {
        $uid = session()->get('user_id');
        if (!$uid) {
            return redirect()->to('/login');
        }
        $data = $this->request->getPost();
        $model = new UserModel();
        $existing = $model->find($uid);
        if (!empty($data['password'])) {
            $current = (string) ($data['current_password'] ?? '');
            if ($current === '') {
                return redirect()->back()->with('error', 'Masukkan password lama untuk konfirmasi');
            }
            if (!$existing || !password_verify($current, (string) ($existing['password'] ?? ''))) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai');
            }
            $data['password'] = password_hash((string) $data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        unset($data['current_password']);
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
        if (!$model->update($uid, $data)) {
            return redirect()->back()->with('error', implode(', ', $model->errors() ?? []));
        }
        if (isset($data['profile_image'])) {
            session()->set('profile_image', $data['profile_image']);
        }
        if (isset($data['name'])) {
            session()->set('name', $data['name']);
        }
        return redirect()->to('/profile')->with('success', 'Profil diperbarui');
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
