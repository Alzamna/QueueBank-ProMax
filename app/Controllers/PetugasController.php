<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;
use App\Models\LoketModel;
use App\Models\UserKategoriModel;

class PetugasController extends BaseController
{
    protected $antrianModel;
    protected $kategoriAntrianModel;
    protected $loketModel;
    protected $userKategoriModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
        $this->loketModel = new LoketModel();
        $this->userKategoriModel = new UserKategoriModel();
    }

    public function dashboard()
    {
        $petugas_id = session()->get('user_id');
        $kategori_id = $this->request->getGet('kategori_id');
        $loket_id = $this->request->getGet('loket_id') ?? null;

        // Get only categories assigned to this staff user
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        
        if (empty($userKategori)) {
            // If user has no assigned categories, show error
            return view('petugas/no_access', [
                'title' => 'Akses Dibatasi',
                'message' => 'Akun Anda belum memiliki kategori layanan yang ditugaskan. Silakan hubungi administrator.'
            ]);
        }
        
        // If no kategori selected, use the first assigned one
        if (!$kategori_id && !empty($userKategori)) {
            $kategori_id = $userKategori[0]['id'];
        }

        $selected_kategori = null;
        $antrian_aktif = [];
        $antrian_dipanggil = [];
        $stats = [
            'menunggu' => 0,
            'dipanggil' => 0,
            'selesai' => 0,
            'lewati' => 0
        ];

        if ($kategori_id) {
            // Verify that the selected category is assigned to this user
            $isAssigned = false;
            foreach ($userKategori as $uk) {
                if ($uk['id'] == $kategori_id) {
                    $isAssigned = true;
                    break;
                }
            }
            
            if (!$isAssigned) {
                // Redirect to first assigned category if selected category is not assigned
                return redirect()->to('petugas/dashboard?kategori_id=' . $userKategori[0]['id']);
            }
            
            $selected_kategori = $this->kategoriAntrianModel->find($kategori_id);
            
            // Get antrian aktif for selected kategori
            $antrian_aktif = $this->antrianModel->getAntrianAktif($kategori_id, $petugas_id);
            
            // Get antrian dipanggil for selected kategori
            $antrian_dipanggil = $this->antrianModel->getAntrianDipanggilByKategori($kategori_id, $petugas_id);
            
            // Get statistics for selected kategori
            $stats = $this->getStatistikKategori($kategori_id);
        }

        $data = [
            'title' => 'Dashboard Petugas',
            'kategori' => $userKategori, // Only show assigned categories
            'selected_kategori' => $selected_kategori,
            'lokets' => $this->loketModel->where('status', 'aktif')->findAll(),
            'antrian_aktif' => $antrian_aktif,
            'antrian_dipanggil' => $antrian_dipanggil,
            'stats' => $stats,
        ];

        return view('petugas/dashboard', $data);
    }

    /**
     * Get statistics for a specific kategori
     */
    private function getStatistikKategori($kategori_id)
    {
        return $this->antrianModel->getStatistikKategori($kategori_id);
    }

    public function panggilAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');
            $loket_id = $this->request->getPost('loket_id');
            $petugas_id = session()->get('user_id');

            // Validate input
            if (!$antrian_id || !$loket_id || !$petugas_id) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Data tidak lengkap: antrian_id, loket_id, atau petugas_id kosong'
                ]);
            }

            $antrian = $this->antrianModel->find($antrian_id);
            if (!$antrian) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian tidak ditemukan'
                ]);
            }

            if ($antrian['status'] !== 'menunggu') {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian sudah tidak dalam status menunggu'
                ]);
            }

            // Verify that the queue category is assigned to this user
            $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
            if (empty($userKategori)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki kategori layanan yang ditugaskan'
                ]);
            }

            $isAssigned = false;
            foreach ($userKategori as $uk) {
                if ($uk['id'] == $antrian['kategori_id']) {
                    $isAssigned = true;
                    break;
                }
            }
            
            if (!$isAssigned) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki akses untuk menangani antrian kategori ini'
                ]);
            }

            // Verify loket exists and is active
            $loket = $this->loketModel->find($loket_id);
            if (!$loket || $loket['status'] !== 'aktif') {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Loket tidak valid atau tidak aktif'
                ]);
            }
            
            try {
                $updateData = [
                    'loket_id' => $loket_id,
                    'petugas_id' => $petugas_id,
                    'status' => 'dipanggil',
                    'waktu_panggil' => date('Y-m-d H:i:s'),
                ];

                $result = $this->antrianModel->update($antrian_id, $updateData);
                
                if ($result) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Antrian berhasil dipanggil',
                        'nomor_antrian' => $antrian['nomor_antrian'],
                        'loket' => $loket['nama_loket']
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false, 
                        'message' => 'Gagal memperbarui status antrian'
                    ]);
                }
            } catch (Exception $e) {
                log_message('error', 'Error panggilAntrian: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Metode request tidak valid']);
    }

    public function selesaiAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');
            $petugas_id = session()->get('user_id');

            // Validate input
            if (!$antrian_id || !$petugas_id) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Data tidak lengkap: antrian_id atau petugas_id kosong'
                ]);
            }

            $antrian = $this->antrianModel->find($antrian_id);
            if (!$antrian) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian tidak ditemukan'
                ]);
            }

            if ($antrian['status'] !== 'dipanggil') {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian harus dalam status dipanggil untuk diselesaikan'
                ]);
            }

            // Verify that the queue category is assigned to this user
            $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
            if (empty($userKategori)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki kategori layanan yang ditugaskan'
                ]);
            }

            $isAssigned = false;
            foreach ($userKategori as $uk) {
                if ($uk['id'] == $antrian['kategori_id']) {
                    $isAssigned = true;
                    break;
                }
            }
            
            if (!$isAssigned) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki akses untuk menangani antrian kategori ini'
                ]);
            }
            
            try {
                $updateData = [
                    'status' => 'selesai',
                    'waktu_selesai' => date('Y-m-d H:i:s'),
                ];

                $result = $this->antrianModel->update($antrian_id, $updateData);
                
                if ($result) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Antrian selesai dilayani'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false, 
                        'message' => 'Gagal memperbarui status antrian'
                    ]);
                }
            } catch (Exception $e) {
                log_message('error', 'Error selesaiAntrian: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Metode request tidak valid']);
    }

    public function lewatiAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');
            $petugas_id = session()->get('user_id');

            // Validate input
            if (!$antrian_id || !$petugas_id) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Data tidak lengkap: antrian_id atau petugas_id kosong'
                ]);
            }

            $antrian = $this->antrianModel->find($antrian_id);
            if (!$antrian) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian tidak ditemukan'
                ]);
            }

            if ($antrian['status'] !== 'dipanggil') {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Antrian harus dalam status dipanggil untuk dilewati'
                ]);
            }

            // Verify that the queue category is assigned to this user
            $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
            if (empty($userKategori)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki kategori layanan yang ditugaskan'
                ]);
            }

            $isAssigned = false;
            foreach ($userKategori as $uk) {
                if ($uk['id'] == $antrian['kategori_id']) {
                    $isAssigned = true;
                    break;
                }
            }
            
            if (!$isAssigned) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Anda tidak memiliki akses untuk menangani antrian kategori ini'
                ]);
            }
            
            try {
                $updateData = [
                    'status' => 'lewati',
                    'waktu_selesai' => date('Y-m-d H:i:s'),
                ];

                $result = $this->antrianModel->update($antrian_id, $updateData);
                
                if ($result) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Antrian dilewati'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false, 
                        'message' => 'Gagal memperbarui status antrian'
                    ]);
                }
            } catch (Exception $e) {
                log_message('error', 'Error lewatiAntrian: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Metode request tidak valid']);
    }

    /**
     * Get antrian by kategori for display
     */
    public function getAntrianByKategori($kategori_id)
    {
        $petugas_id = session()->get('user_id');
        
        // Verify that the selected category is assigned to this user
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        $isAssigned = false;
        foreach ($userKategori as $uk) {
            if ($uk['id'] == $kategori_id) {
                $isAssigned = true;
                break;
            }
        }
        
        if (!$isAssigned) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke kategori ini'
            ]);
        }
        
        $antrian_aktif = $this->antrianModel->getAntrianAktif($kategori_id, $petugas_id);
        $antrian_dipanggil = $this->antrianModel->getAntrianDipanggilByKategori($kategori_id, $petugas_id);
        $stats = $this->getStatistikKategori($kategori_id);

        return $this->response->setJSON([
            'success' => true,
            'antrian_aktif' => $antrian_aktif,
            'antrian_dipanggil' => $antrian_dipanggil,
            'stats' => $stats
        ]);
    }

    /**
     * Get dashboard summary for all categories
     */
    public function getDashboardSummary()
    {
        $petugas_id = session()->get('user_id');
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        $summary = [];

        foreach ($userKategori as $kat) {
            $stats = $this->getStatistikKategori($kat['id']);
            $summary[] = [
                'kategori' => $kat,
                'stats' => $stats,
                'total' => array_sum($stats)
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'summary' => $summary
        ]);
    }

    /**
     * Route to specific dashboard based on kategori
     */
    public function dashboardKategori($kategori_id = null)
    {
        if (!$kategori_id) {
            return redirect()->to('petugas/dashboard');
        }

        $petugas_id = session()->get('user_id');
        
        // Verify that the selected category is assigned to this user
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        $isAssigned = false;
        foreach ($userKategori as $uk) {
            if ($uk['id'] == $kategori_id) {
                $isAssigned = true;
                break;
            }
        }
        
        if (!$isAssigned) {
            return redirect()->to('petugas/dashboard');
        }

        $kategori = $this->kategoriAntrianModel->find($kategori_id);
        if (!$kategori) {
            return redirect()->to('petugas/dashboard');
        }

        $loket_id = $this->request->getGet('loket_id') ?? null;

        // Get antrian aktif for selected kategori
        $antrian_aktif = $this->antrianModel->getAntrianAktif($kategori_id, $petugas_id);
        
        // Get antrian dipanggil for selected kategori
        $antrian_dipanggil = $this->antrianModel->getAntrianDipanggilByKategori($kategori_id, $petugas_id);
        
        // Get statistics for selected kategori
        $stats = $this->getStatistikKategori($kategori_id);

        $data = [
            'title' => 'Dashboard ' . $kategori['nama_kategori'],
            'kategori' => $kategori,
            'lokets' => $this->loketModel->where('status', 'aktif')->findAll(),
            'antrian_aktif' => $antrian_aktif,
            'antrian_dipanggil' => $antrian_dipanggil,
            'stats' => $stats,
        ];

        // Route to specific dashboard based on kategori name
        $kategori_name = strtolower($kategori['nama_kategori']);
        
        if (strpos($kategori_name, 'teller') !== false) {
            return view('petugas/dashboard_teller', $data);
        } elseif (strpos($kategori_name, 'cs') !== false || strpos($kategori_name, 'customer') !== false) {
            return view('petugas/dashboard_cs', $data);
        } elseif (strpos($kategori_name, 'prioritas') !== false) {
            return view('petugas/dashboard_prioritas', $data);
        } else {
            // Default dashboard for other categories
            return view('petugas/dashboard', $data);
        }
    }

    /**
     * Get kategori info for routing
     */
    public function getKategoriInfo()
    {
        $petugas_id = session()->get('user_id');
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        
        return $this->response->setJSON([
            'success' => true,
            'kategori' => $userKategori
        ]);
    }

    /**
     * Debug method to check user's assigned categories and current session
     */
    public function debugUserAccess()
    {
        $petugas_id = session()->get('user_id');
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
        
        $debugData = [
            'session_user_id' => $petugas_id,
            'session_role' => session()->get('role'),
            'session_username' => session()->get('username'),
            'assigned_categories' => $userKategori,
            'total_categories' => count($userKategori),
            'current_time' => date('Y-m-d H:i:s')
        ];
        
        return $this->response->setJSON([
            'success' => true,
            'debug_data' => $debugData
        ]);
    }

    /**
     * Test method to verify database connections and models
     */
    public function testSystem()
    {
        try {
            $tests = [];
            
            // Test database connection
            $tests['database'] = $this->db->connect() ? 'Connected' : 'Failed';
            
            // Test models
            $tests['user_model'] = $this->userModel->countAll() >= 0 ? 'Working' : 'Failed';
            $tests['antrian_model'] = $this->antrianModel->countAll() >= 0 ? 'Working' : 'Failed';
            $tests['user_kategori_model'] = $this->userKategoriModel->countAll() >= 0 ? 'Working' : 'Failed';
            
            // Test current user categories
            $petugas_id = session()->get('user_id');
            $userKategori = $this->userKategoriModel->getCategoriesByUserId($petugas_id);
            $tests['user_categories'] = count($userKategori);
            
            return $this->response->setJSON([
                'success' => false,
                'tests' => $tests,
                'user_categories' => $userKategori
            ]);
            
        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
