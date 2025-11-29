<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $username = trim((string) ($data['username'] ?? ''));
            $password = (string) ($data['password'] ?? '');

            $users = new UserModel();

            if (!$users->first()) {
                return redirect()->back()->with('error', 'User not found');
            }

            $user = $users->where('username', $username)->first();
            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Username atau password salah');
            }
            $session = session();
            $session->set(['user_id' => $user['id'], 'role' => $user['role'] ?? 'Employee', 'name' => $user['name'], 'nin' => $user['nin'] ?? null]);
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
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
