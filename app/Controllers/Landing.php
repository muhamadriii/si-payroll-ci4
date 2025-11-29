<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Landing extends Controller
{
    public function index()
    {
        $session = session();
        if ($session->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('landing/index');
    }
}

