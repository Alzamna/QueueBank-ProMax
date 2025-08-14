<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;
use CodeIgniter\HTTP\ResponseInterface;

class AntrianController extends BaseController
{
    protected $antrianModel;
    protected $kategoriAntrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
    }

    public function index()
    {
        // Redirect langsung ke mobile view sebagai default
        return redirect()->to('/antrian/mobile');
    }
    
    public function desktop()
    {
        $kategori = $this->kategoriAntrianModel->where('status', 'aktif')->findAll();
        
        // Debug information
        log_message('debug', 'Desktop method called');
        log_message('debug', 'Categories found: ' . json_encode($kategori));
        
        $data = [
            'title' => 'Ambil Nomor Antrian - Desktop',
            'kategori' => $kategori,
        ];

        return view('antrian/index', $data);
    }
    
    public function mobile()
    {
        $kategori = $this->kategoriAntrianModel->where('status', 'aktif')->findAll();
        
        // Debug information
        log_message('debug', 'Mobile method called');
        log_message('debug', 'Categories found: ' . json_encode($kategori));
        
        $data = [
            'title' => 'Mesin Antrian Mobile',
            'kategori' => $kategori,
        ];

        return view('antrian/mobile', $data);
    }
    
    // Test endpoint for debugging
    public function test()
    {
        log_message('debug', 'Test endpoint called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'GET data: ' . json_encode($this->request->getGet()));
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Test endpoint working',
            'post_data' => $this->request->getPost(),
            'get_data' => $this->request->getGet(),
            'method' => $this->request->getMethod()
        ]);
    }

    public function ambilNomor()
    {
        // Debug information
        log_message('debug', 'AmbilNomor method called');
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        
        if ($this->request->getMethod() === 'POST') {
            $kategori_id = $this->request->getPost('kategori_id');
            
            log_message('debug', 'Kategori ID received: ' . $kategori_id);
            log_message('debug', 'Kategori ID type: ' . gettype($kategori_id));
            log_message('debug', 'Raw POST data: ' . json_encode($this->request->getPost()));
            
            // Validate kategori_id
            if (!$kategori_id) {
                log_message('error', 'Empty kategori_id received');
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'ID kategori diperlukan'
                ]);
            }
            
            // Convert to integer if it's a string
            $kategori_id = intval($kategori_id);
            
            if ($kategori_id <= 0) {
                log_message('error', 'Invalid kategori_id: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'ID kategori tidak valid'
                ]);
            }

            // Check if kategori exists and is active
            $kategori = $this->kategoriAntrianModel->where('id', $kategori_id)
                                                   ->where('status', 'aktif')
                                                   ->first();
            if (!$kategori) {
                log_message('error', 'Kategori not found or inactive: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Kategori tidak ditemukan atau tidak aktif'
                ]);
            }

            // Get user agent and IP for logging
            $user_agent = $this->request->getUserAgent()->getAgentString();
            $ip_address = $this->getClientIp();

            // Get device ID from session or generate new one
            $session = session();
            $device_id = $session->get('device_id');
            
            if (!$device_id) {
                // Generate new device ID for this session
                $device_id = 'mobile_' . uniqid() . '_' . time();
                $session->set('device_id', $device_id);
            }

            log_message('debug', 'User agent: ' . $user_agent . ', IP: ' . $ip_address . ', Device ID: ' . $device_id);

            // Check if user already has an active queue number
            $existing_antrian = $this->antrianModel->getAntrianAktifMobile($device_id);
            
            if ($existing_antrian) {
                // Return existing queue number
                $posisi_antrian = $this->antrianModel->getPosisiAntrian(
                    $existing_antrian['id'], 
                    $existing_antrian['kategori_id']
                );
                
                log_message('info', 'User already has active queue: ' . $existing_antrian['nomor_antrian']);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Anda sudah memiliki nomor antrian aktif',
                    'nomor_antrian' => $existing_antrian['nomor_antrian'],
                    'antrian_id' => $existing_antrian['id'],
                    'kategori' => $existing_antrian['nama_kategori'],
                    'posisi_antrian' => $posisi_antrian,
                    'existing' => true
                ]);
            }

            // Generate new queue number
            $nomor_antrian = $this->antrianModel->getNextNomorAntrian($kategori_id);
            if (!$nomor_antrian) {
                log_message('error', 'Failed to generate nomor antrian for kategori: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal generate nomor antrian'
                ]);
            }

            $data = [
                'nomor_antrian' => $nomor_antrian,
                'kategori_id' => $kategori_id,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d H:i:s'),
                'device_id' => $device_id,
                'user_agent' => $user_agent,
                'ip_address' => $ip_address
            ];

            $antrian_id = $this->antrianModel->insert($data);

            if ($antrian_id) {
                // Calculate queue position
                $posisi_antrian = $this->antrianModel->getPosisiAntrian($antrian_id, $kategori_id);
                
                log_message('info', 'Successfully created antrian: ' . $antrian_id . ' with nomor: ' . $nomor_antrian);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Nomor antrian berhasil diambil',
                    'nomor_antrian' => $nomor_antrian,
                    'antrian_id' => $antrian_id,
                    'kategori' => $kategori['nama_kategori'],
                    'posisi_antrian' => $posisi_antrian,
                    'existing' => false
                ]);
            } else {
                log_message('error', 'Failed to insert antrian data');
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal menyimpan data antrian'
                ]);
            }
        }

        log_message('error', 'Invalid request method: ' . $this->request->getMethod());
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Method tidak valid. Expected POST, got ' . $this->request->getMethod()
        ]);
    }

    public function cekStatus($antrian_id = null)
    {
        if ($antrian_id) {
            $antrian = $this->antrianModel
                ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix')
                ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
                ->where('antrians.id', $antrian_id)
                ->first();

            if ($antrian) {
                $posisi_antrian = $this->antrianModel->getPosisiAntrian(
                    $antrian['id'], 
                    $antrian['kategori_id']
                );

                return $this->response->setJSON([
                    'success' => true,
                    'antrian' => $antrian,
                    'posisi_antrian' => $posisi_antrian
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Antrian tidak ditemukan'
        ]);
    }

    /**
     * Check mobile device's active queue status
     * @return ResponseInterface
     */
    public function cekStatusMobile()
    {
        // Get device ID from session or generate new one
        $session = session();
        $device_id = $session->get('device_id');
        
        if (!$device_id) {
            // Generate new device ID for this session
            $device_id = 'mobile_' . uniqid() . '_' . time();
            $session->set('device_id', $device_id);
        }

        $antrian = $this->antrianModel->getAntrianAktifMobile($device_id);
        
        if ($antrian) {
            $posisi_antrian = $this->antrianModel->getPosisiAntrian(
                $antrian['id'], 
                $antrian['kategori_id']
            );
            
            $total_antrian = $this->antrianModel->getTotalAntrianAktif($antrian['kategori_id']);
            
            return $this->response->setJSON([
                'success' => true,
                'antrian' => $antrian,
                'posisi_antrian' => $posisi_antrian,
                'total_antrian' => $total_antrian
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Tidak ada nomor antrian aktif'
        ]);
    }

    /**
     * Get queue statistics for display
     * @return ResponseInterface
     */
    public function getStatistikAntrian()
    {
        $kategori_list = $this->kategoriAntrianModel->where('status', 'aktif')->findAll();
        $statistik = [];

        foreach ($kategori_list as $kategori) {
            $total_antrian = $this->antrianModel->getTotalAntrianAktif($kategori['id']);
            $antrian_dipanggil = $this->antrianModel->getAntrianDipanggil();
            
            $statistik[] = [
                'kategori' => $kategori['nama_kategori'],
                'prefix' => $kategori['prefix'],
                'total_antrian' => $total_antrian,
                'antrian_dipanggil' => $antrian_dipanggil
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'statistik' => $statistik,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }



    /**
     * Get client IP address
     * @return string
     */
    private function getClientIp()
    {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
