<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;
use CodeIgniter\HTTP\ResponseInterface;

class DesktopController extends BaseController
{
    protected $antrianModel;
    protected $kategoriAntrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
    }

    /**
     * Desktop queue machine interface
     * @return string
     */
    public function index()
    {
        // Force desktop detection for this controller
        $kategori = $this->kategoriAntrianModel->where('status', 'aktif')->findAll();
        
        $data = [
            'title' => 'Mesin Antrian - Desktop',
            'kategori' => $kategori,
            'device_type' => 'desktop'
        ];

        return view('desktop/index', $data);
    }

    /**
     * Generate new queue number for desktop (always new)
     * @return ResponseInterface
     */
    public function ambilNomorDesktop()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Method tidak valid'
            ]);
        }

        $kategori_id = $this->request->getPost('kategori_id');
        
        // Debug logging
        log_message('debug', 'Desktop ambilNomorDesktop called');
        log_message('debug', 'Kategori ID received: ' . $kategori_id);
        log_message('debug', 'Kategori ID type: ' . gettype($kategori_id));
        log_message('debug', 'Raw POST data: ' . json_encode($this->request->getPost()));
        
        if (!$kategori_id) {
            log_message('error', 'Empty kategori_id received in desktop');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID kategori diperlukan'
            ]);
        }
        
        // Convert to integer if it's a string
        $kategori_id = intval($kategori_id);
        
        if ($kategori_id <= 0) {
            log_message('error', 'Invalid kategori_id in desktop: ' . $kategori_id);
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
            log_message('error', 'Kategori not found or inactive in desktop: ' . $kategori_id);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori tidak ditemukan atau tidak aktif'
            ]);
        }

        // Generate new queue number (always new for desktop)
        $nomor_antrian = $this->antrianModel->getNextNomorAntrian($kategori_id);
        if (!$nomor_antrian) {
            log_message('error', 'Failed to generate nomor antrian for desktop kategori: ' . $kategori_id);
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
            'device_type' => 'desktop',
            'device_id' => null, // Desktop tidak menyimpan device ID
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->getClientIp()
        ];

        $antrian_id = $this->antrianModel->insert($data);

        if ($antrian_id) {
            $posisi_antrian = $this->antrianModel->getPosisiAntrian($antrian_id, $kategori_id);
            
            log_message('info', 'Successfully created desktop antrian: ' . $antrian_id . ' with nomor: ' . $nomor_antrian);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nomor antrian berhasil diambil',
                'nomor_antrian' => $nomor_antrian,
                'antrian_id' => $antrian_id,
                'kategori' => $kategori['nama_kategori'],
                'posisi_antrian' => $posisi_antrian,
                'device_type' => 'desktop',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } else {
            log_message('error', 'Failed to insert desktop antrian data');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data antrian'
            ]);
        }
    }

    /**
     * Get current queue statistics for display
     * @return ResponseInterface
     */
    public function getStatistikHarian()
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
