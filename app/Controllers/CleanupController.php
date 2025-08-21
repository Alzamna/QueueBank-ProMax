<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;

class CleanupController extends BaseController
{
    protected $antrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
    }

    /**
     * Cleanup semua antrian (untuk diakses via URL)
     */
    public function cleanupAntrian()
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak. Hanya admin yang dapat melakukan cleanup.'
            ]);
        }

        // Perform cleanup
        $result = $this->antrianModel->cleanupAntrian();
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Semua antrian berhasil dihapus dari database',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus antrian dari database'
            ]);
        }
    }

    /**
     * Cleanup antrian berdasarkan tanggal
     */
    public function cleanupAntrianByDate($tanggal = null)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak. Hanya admin yang dapat melakukan cleanup.'
            ]);
        }

        // If no date provided, use yesterday
        if ($tanggal === null) {
            $tanggal = date('Y-m-d', strtotime('-1 day'));
        }

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD'
            ]);
        }

        // Perform cleanup
        $result = $this->antrianModel->cleanupAntrianByDate($tanggal);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Antrian untuk tanggal ' . $tanggal . ' berhasil dihapus',
                'tanggal' => $tanggal,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus antrian untuk tanggal ' . $tanggal
            ]);
        }
    }
}
