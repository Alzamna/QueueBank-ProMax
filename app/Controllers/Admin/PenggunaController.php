<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\KategoriAntrianModel;
use App\Models\UserKategoriModel;
use App\Models\LoketModel;

class PenggunaController extends BaseController
{
	protected $userModel;
	protected $kategoriModel;
	protected $userKategoriModel;
	protected $loketModel;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->kategoriModel = new KategoriAntrianModel();
		$this->userKategoriModel = new UserKategoriModel();
		$this->loketModel = new LoketModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Kelola Pengguna',
			'users' => $this->userModel->getUsersWithDetails(),
			'total_users' => $this->userModel->countAll(),
			'admin_count' => $this->userModel->where('role', 'admin')->countAllResults(),
			'petugas_count' => $this->userModel->where('role', 'petugas')->countAllResults(),
			'kategori_list' => $this->kategoriModel->where('status', 'aktif')->orderBy('nama_kategori', 'ASC')->findAll(),
			'loket_list' => $this->loketModel->where('status', 'aktif')->orderBy('nama_loket', 'ASC')->findAll()
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

		$role = $this->request->getPost('role');
		$loket_id = $this->request->getPost('loket_id');
		
		// Validate loket_id for petugas
		if ($role === 'petugas' && empty($loket_id)) {
			session()->setFlashdata('error', 'Loket harus dipilih untuk petugas');
			return redirect()->back()->withInput();
		}
		
		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role' => $role,
			'loket_id' => $role === 'petugas' ? $loket_id : null
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
			$userId = $this->userModel->insert($data);
			
			// If user is petugas, assign categories
			if ($data['role'] === 'petugas' && $this->request->getPost('kategori_ids')) {
				$kategoriIds = $this->request->getPost('kategori_ids');
				$this->userKategoriModel->assignCategoriesToUser($userId, $kategoriIds);
			}
			
			session()->setFlashdata('message', 'Pengguna berhasil ditambahkan');
		} catch (\Exception $e) {
			session()->setFlashdata('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
		}
		
		return redirect()->to('admin/pengguna/pengguna');
	}

	public function edit($id)
	{
		// Redirect to main page since we now use modal for editing
		return redirect()->to('admin/pengguna/pengguna');
	}

	public function update($id)
	{
		// Debug logging
		log_message('info', 'Update user request received for ID: ' . $id);
		log_message('info', 'Request method: ' . $this->request->getMethod());
		log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'Yes' : 'No'));
		log_message('info', 'Headers: ' . json_encode($this->request->getHeaders()));
		log_message('info', 'Post data: ' . json_encode($this->request->getPost()));
		
		// Set JSON response headers
		$this->response->setHeader('Content-Type', 'application/json');
		
		$user = $this->userModel->find($id);
		if (empty($user)) {
			log_message('error', 'User not found for ID: ' . $id);
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Pengguna tidak ditemukan'
			]);
		}

		$role = $this->request->getPost('role');
		$loket_id = $this->request->getPost('loket_id');
		
		// Validate loket_id for petugas
		if ($role === 'petugas' && empty($loket_id)) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Loket harus dipilih untuk petugas'
			]);
		}
		
		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'role' => $role,
			'loket_id' => $role === 'petugas' ? $loket_id : null
		];

		// Check if password is provided
		$password = $this->request->getPost('password');
		if (!empty($password)) {
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		// Validate username uniqueness (excluding current user)
		$existingUser = $this->userModel->where('username', $data['username'])->where('id !=', $id)->first();
		if ($existingUser) {
			log_message('warning', 'Username already exists: ' . $data['username']);
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Username sudah digunakan'
			]);
		}

		// Validate email uniqueness (excluding current user)
		$existingEmail = $this->userModel->where('email', $data['email'])->where('id !=', $id)->first();
		if ($existingEmail) {
			log_message('warning', 'Email already exists: ' . $data['email']);
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Email sudah digunakan'
			]);
		}

		try {
			log_message('info', 'Starting user update for ID: ' . $id);
			
			// Skip validation for update since we handle uniqueness manually
			$this->userModel->skipValidation(true);
			$updateResult = $this->userModel->update($id, $data);
			
			log_message('info', 'User update result: ' . ($updateResult ? 'success' : 'failed'));
			
			// Update user's assigned categories if role is petugas
			if ($data['role'] === 'petugas' && $this->request->getPost('kategori_ids')) {
				$kategoriIds = $this->request->getPost('kategori_ids');
				log_message('info', 'Updating categories for user: ' . json_encode($kategoriIds));
				$this->userKategoriModel->assignCategoriesToUser($id, $kategoriIds);
			} else {
				// Remove all category assignments if role is not petugas
				log_message('info', 'Removing all category assignments for user');
				$this->userKategoriModel->where('user_id', $id)->delete();
			}
			
			log_message('info', 'Sending AJAX response: success');
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Pengguna berhasil diperbarui'
			]);
			
		} catch (\Exception $e) {
			log_message('error', 'Exception in user update: ' . $e->getMessage());
			log_message('error', 'Stack trace: ' . $e->getTraceAsString());
			
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()
			]);
		}
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