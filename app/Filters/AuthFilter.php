<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'));
        }

        // Cek role untuk akses admin
        $path = $request->getUri()->getPath();
        if (strpos($path, 'admin') === 0 && session()->get('role') !== 'admin') {
            return redirect()->to(site_url('petugas/dashboard'))->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }

        // Cek role untuk akses petugas
        if (strpos($path, 'petugas') === 0 && session()->get('role') !== 'petugas' && session()->get('role') !== 'admin') {
            return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki akses ke halaman petugas');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}