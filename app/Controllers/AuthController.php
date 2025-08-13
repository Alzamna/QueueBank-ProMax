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
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to(site_url('admin/dashboard'));
            } else {
                return redirect()->to(site_url('petugas/dashboard'));
            }
        }

        // Set title untuk halaman login
        $data = [
            'title' => 'Login - QueueBank ProMax'
        ];

        if ($this->request->getMethod() === 'POST') {
            // Validasi input
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->with('error', 'Username atau password tidak valid')
                    ->withInput();
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                session()->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'logged_in' => true
                ]);

                // Log aktivitas login
                log_message('info', 'User {username} logged in', ['username' => $username]);
                
                // Debug session
                log_message('debug', 'Session data: ' . json_encode(session()->get()));

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    log_message('debug', 'Redirecting to admin dashboard');
                    return redirect()->to(site_url('admin/dashboard'));
                } else {
                    log_message('debug', 'Redirecting to petugas dashboard');
                    return redirect()->to(site_url('petugas/dashboard'));
                }
            } else {
                // Jika login gagal
                return redirect()->back()
                    ->with('error', 'Username atau password salah')
                    ->withInput();
            }
        }

        return view('auth/login', $data);
    }

    public function logout()
    {
        // Log aktivitas logout
        if (session()->get('logged_in')) {
            log_message('info', 'User {username} logged out', ['username' => session()->get('username')]);
        }

        // Hapus semua data session
        session()->destroy();
        
        return redirect()->to(site_url('login'))->with('message', 'Anda telah berhasil logout');
    }
}
