<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'logged_in' => true
                ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/petugas/dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Username atau password salah');
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
