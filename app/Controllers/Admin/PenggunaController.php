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
			'users' => $this->userModel->findAll(),
			'total_users' => $this->userModel->countAll(),
			'admin_count' => $this->userModel->where('role', 'admin')->countAllResults(),
			'petugas_count' => $this->userModel->where('role', 'petugas')->countAllResults()
		];

		return view('admin/pengguna/pengguna', $data);
	}

	public function add()
	{
		$password = $this->request->getPost('password');
		$confirmPassword = $this->request->getPost('confirm_password');

		// Validate password confirmation
		if ($password !== $confirmPassword) {
			session()->setFlashdata('error', 'Password dan konfirmasi password tidak cocok');
			return redirect()->back()->withInput();
		}

		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role' => $this->request->getPost('role')
		];

		// Validate username uniqueness
		$existingUser = $this->userModel->where('username', $data['username'])->first();
		if ($existingUser) {
			session()->setFlashdata('error', 'Username sudah digunakan');
			return redirect()->back()->withInput();
		}

		// Validate email uniqueness
		$existingEmail = $this->userModel->where('email', $data['email'])->first();
		if ($existingEmail) {
			session()->setFlashdata('error', 'Email sudah digunakan');
			return redirect()->back()->withInput();
		}

		try {
			// Skip validation since we handle uniqueness manually
			$this->userModel->skipValidation(true);
			$this->userModel->insert($data);
			session()->setFlashdata('message', 'Pengguna berhasil ditambahkan');
		} catch (\Exception $e) {
			session()->setFlashdata('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
		}
		
		return redirect()->to('admin/pengguna/pengguna');
	}

	public function edit($id)
	{
		$data = [
			'title' => 'Edit Pengguna',
			'user' => $this->userModel->find($id)
		];

		if (empty($data['user'])) {
			session()->setFlashdata('error', 'Pengguna tidak ditemukan');
			return redirect()->to('admin/pengguna/pengguna');
		}

		return view('admin/pengguna/edit', $data);
	}

	public function update($id)
	{
		$user = $this->userModel->find($id);
		if (empty($user)) {
			session()->setFlashdata('error', 'Pengguna tidak ditemukan');
			return redirect()->to('admin/pengguna/pengguna');
		}

		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'role' => $this->request->getPost('role')
		];

		// Check if password is provided
		$password = $this->request->getPost('password');
		if (!empty($password)) {
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		// Validate username uniqueness (excluding current user)
		$existingUser = $this->userModel->where('username', $data['username'])->where('id !=', $id)->first();
		if ($existingUser) {
			session()->setFlashdata('error', 'Username sudah digunakan');
			return redirect()->back()->withInput();
		}

		// Validate email uniqueness (excluding current user)
		$existingEmail = $this->userModel->where('email', $data['email'])->where('id !=', $id)->first();
		if ($existingEmail) {
			session()->setFlashdata('error', 'Email sudah digunakan');
			return redirect()->back()->withInput();
		}

		try {
			// Skip validation for update since we handle uniqueness manually
			$this->userModel->skipValidation(true);
			$this->userModel->update($id, $data);
			session()->setFlashdata('message', 'Pengguna berhasil diperbarui');
		} catch (\Exception $e) {
			session()->setFlashdata('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
			return redirect()->back()->withInput();
		}
		
		return redirect()->to('admin/pengguna/pengguna');
	}

	public function delete($id)
	{
		// Prevent deleting the current admin user
		if ($id == session()->get('user_id')) {
			session()->setFlashdata('error', 'Tidak dapat menghapus akun yang sedang digunakan');
			return redirect()->to('admin/pengguna/pengguna');
		}

		// Check if this is the last admin
		$user = $this->userModel->find($id);
		if ($user && $user['role'] === 'admin') {
			$adminCount = $this->userModel->where('role', 'admin')->countAllResults();
			if ($adminCount <= 1) {
				session()->setFlashdata('error', 'Tidak dapat menghapus admin terakhir');
				return redirect()->to('admin/pengguna/pengguna');
			}
		}

		$this->userModel->delete($id);
		session()->setFlashdata('message', 'Pengguna berhasil dihapus');
		return redirect()->to('admin/pengguna/pengguna');
	}


} 