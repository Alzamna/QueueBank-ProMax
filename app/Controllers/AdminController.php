<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoketModel;
use App\Models\KategoriAntrianModel;
use App\Models\AntrianModel;
use App\Models\PengaturanDisplayModel;
use App\Models\PenggunaModel;
use App\Models\UserKategoriModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $loketModel;
    protected $kategoriAntrianModel;
    protected $antrianModel;
    protected $pengaturanDisplayModel;
    protected $penggunaModel;
    protected $userKategoriModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->loketModel = new LoketModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
        $this->antrianModel = new AntrianModel();
        $this->pengaturanDisplayModel = new PengaturanDisplayModel();
        $this->penggunaModel = new PenggunaModel();
        $this->userKategoriModel = new UserKategoriModel();
    }

    public function dashboard()
    {
        $statistik = $this->antrianModel->getStatistikHarianLengkap();
        
        $data = [
            'title' => 'Dashboard Admin',
            'totalUsers' => $this->userModel->countAll(),
            'totalLokets' => $this->loketModel->countAll(),
            'totalKategori' => $this->kategoriAntrianModel->countAll(),
            'totalAntrianHariIni' => $this->antrianModel->where('DATE(antrians.waktu_ambil)', date('Y-m-d'))->countAllResults(),
            'statistik' => $statistik ?: [],
            'pengguna' => $this->userModel->countAll(),
        ];

        return view('admin/dashboard', $data);
    }

    public function pengguna()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->getUsersWithDetails(),
            'loket_list' => $this->loketModel->where('status', 'aktif')->orderBy('nama_loket', 'ASC')->findAll(),
            'kategori_list' => $this->kategoriAntrianModel->where('status', 'aktif')->orderBy('nama_kategori', 'ASC')->findAll(),
        ];

        return view('admin/pengguna/pengguna', $data);
    }

    public function lokets()
    {
        $data = [
            'title' => 'Kelola Loket',
            'lokets' => $this->loketModel->findAll(),
        ];

        return view('admin/lokets/index', $data);
    }

    public function kategoriAntrian()
    {
        $data = [
            'title' => 'Kelola Kategori Antrian',
            'kategori' => $this->kategoriAntrianModel->findAll(),
        ];

        return view('admin/kategori/index', $data);
    }

    public function pengaturan()
    {
        $data = [
            'title' => 'Pengaturan Display',
            'pengaturan' => $this->pengaturanDisplayModel->first(),
        ];

        return view('admin/pengaturan/index', $data);
    }

    public function laporan()
    {
        $statistik = $this->antrianModel->getStatistikHarianLengkap();
        
        $data = [
            'title' => 'Laporan',
            'statistik' => $statistik ?: [],
        ];

        return view('admin/laporan/index', $data);
    }

    public function userKategori()
    {
        $data = [
            'title' => 'Kelola Kategori Pengguna',
            'users' => $this->userModel->where('role', 'petugas')->findAll(),
            'kategori' => $this->kategoriAntrianModel->where('status', 'aktif')->findAll(),
            'userKategori' => $this->userKategoriModel->getAllUserKategori(),
        ];

        return view('admin/user_kategori/index', $data);
    }

    public function assignKategori()
    {
        if ($this->request->getMethod() === 'post') {
            $user_id = $this->request->getPost('user_id');
            $kategori_ids = $this->request->getPost('kategori_ids');

            if ($this->userKategoriModel->assignCategoriesToUser($user_id, $kategori_ids)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kategori berhasil ditugaskan ke pengguna'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menugaskan kategori ke pengguna'
                ]);
                }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
    }

    public function getUserKategori($user_id)
    {
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($user_id);
        
        return $this->response->setJSON([
            'success' => true,
            'userKategori' => $userKategori
        ]);
    }

    public function addPengguna()
    {
        // Debug: Log the request method and data
        log_message('debug', 'AddPengguna called with method: ' . $this->request->getMethod());
        log_message('debug', 'AddPengguna POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'AddPengguna is AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        
        // Accept any request method for now (for debugging)
        $postData = $this->request->getPost();
        log_message('debug', 'POST data received: ' . json_encode($postData));
        
        // If no POST data, try to get from input stream
        if (empty($postData)) {
            $input = $this->request->getBody();
            log_message('debug', 'Raw input: ' . $input);
            parse_str($input, $postData);
            log_message('debug', 'Parsed input: ' . json_encode($postData));
        }
        
        if (!empty($postData)) {
            $role = $postData['role'] ?? '';
            $loket_id = $postData['loket_id'] ?? '';
            
            // Validate loket_id for petugas
            if ($role === 'petugas' && empty($loket_id)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Loket harus dipilih untuk petugas'
                ]);
            }
            
            $data = [
                'nama_lengkap' => $postData['nama_lengkap'] ?? '',
                'username' => $postData['username'] ?? '',
                'email' => $postData['email'] ?? '',
                'password' => password_hash($postData['password'] ?? '', PASSWORD_DEFAULT),
                'role' => $role,
                'loket_id' => $role === 'petugas' ? $loket_id : null,
            ];

            // Validate password confirmation
            if (($postData['password'] ?? '') !== ($postData['confirm_password'] ?? '')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Konfirmasi password tidak cocok'
                ]);
            }

            // Check if username already exists
            if ($this->userModel->where('username', $data['username'])->first()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username sudah digunakan'
                ]);
            }

            // Check if email already exists
            if ($this->userModel->where('email', $data['email'])->first()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email sudah digunakan'
                ]);
            }

            if ($this->userModel->insert($data)) {
                $user_id = $this->userModel->insertID();
                
                // Assign kategori if role is petugas
                if ($data['role'] === 'petugas' && isset($postData['kategori_ids'])) {
                    $kategori_ids = $postData['kategori_ids'];
                    $this->userKategoriModel->assignCategoriesToUser($user_id, $kategori_ids);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Pengguna berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan pengguna'
                ]);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No data received']);
        }
    }

    public function updatePengguna($user_id)
    {
        // Debug: Log the request method and data
        log_message('debug', 'UpdatePengguna called with method: ' . $this->request->getMethod());
        log_message('debug', 'UpdatePengguna POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'UpdatePengguna is AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        
        // Accept any request method for now (for debugging)
        $postData = $this->request->getPost();
        log_message('debug', 'POST data received: ' . json_encode($postData));
        
        // If no POST data, try to get from input stream
        if (empty($postData)) {
            $input = $this->request->getBody();
            log_message('debug', 'Raw input: ' . $input);
            parse_str($input, $postData);
            log_message('debug', 'Parsed input: ' . json_encode($postData));
        }
        
        if (!empty($postData)) {
            $role = $postData['role'] ?? '';
            $loket_id = $postData['loket_id'] ?? '';
            
            // Validate loket_id for petugas
            if ($role === 'petugas' && empty($loket_id)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Loket harus dipilih untuk petugas'
                ]);
            }
            
            $data = [
                'nama_lengkap' => $postData['nama_lengkap'] ?? '',
                'username' => $postData['username'] ?? '',
                'email' => $postData['email'] ?? '',
                'role' => $role,
                'loket_id' => $role === 'petugas' ? $loket_id : null,
            ];

            // Add password if provided
            if (!empty($postData['password'])) {
                $data['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
            }

            // Check if username already exists (excluding current user)
            $existingUser = $this->userModel->where('username', $data['username'])->where('id !=', $user_id)->first();
            if ($existingUser) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username sudah digunakan'
                ]);
            }

            // Check if email already exists (excluding current user)
            $existingUser = $this->userModel->where('email', $data['email'])->where('id !=', $user_id)->first();
            if ($existingUser) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email sudah digunakan'
                ]);
            }

            if ($this->userModel->update($user_id, $data)) {
                // Update kategori assignment if role is petugas
                if ($data['role'] === 'petugas' && isset($postData['kategori_ids'])) {
                    $kategori_ids = $postData['kategori_ids'];
                    $this->userKategoriModel->assignCategoriesToUser($user_id, $kategori_ids);
                } else {
                    // Remove all kategori assignments if role is not petugas
                    $this->userKategoriModel->removeAllCategoriesFromUser($user_id);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Pengguna berhasil diupdate'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate pengguna'
                ]);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No data received']);
        }
    }

    public function deletePengguna($user_id)
    {
        if ($this->userModel->delete($user_id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus pengguna'
            ]);
        }
    }

    // Test method to check loket data
    public function testLoket()
    {
        $lokets = $this->loketModel->findAll();
        $aktifLokets = $this->loketModel->where('status', 'aktif')->findAll();
        
        echo "All lokets: " . json_encode($lokets) . "\n";
        echo "Active lokets: " . json_encode($aktifLokets) . "\n";
        echo "Total lokets: " . count($lokets) . "\n";
        echo "Total active lokets: " . count($aktifLokets) . "\n";
    }
}
