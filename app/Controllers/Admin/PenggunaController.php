<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class PenggunaController extends BaseController
{
	protected $userModel;

	public function __construct()
	{
		$this->userModel = new UserModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Kelola Pengguna',
			'users' => $this->userModel->findAll()
		];

		return view('admin/pengguna/pengguna', $data);
	}

	public function add()
	{
		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'role' => $this->request->getPost('role')
		];

		$this->userModel->insert($data);
		session()->setFlashdata('message', 'Pengguna berhasil ditambahkan');
		return redirect()->to('admin/pengguna/pengguna');
	}

	public function delete($id)
	{
		$this->userModel->delete($id);
		session()->setFlashdata('message', 'Pengguna berhasil dihapus');
		return redirect()->to('admin/pengguna/pengguna');
	}
} 