<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\PengaturanDisplayModel;

class DisplayController extends BaseController
{
    protected $antrianModel;
    protected $pengaturanDisplayModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->pengaturanDisplayModel = new PengaturanDisplayModel();
    }

    /**
     * Halaman utama display publik
     */
    public function index()
    {
        $data = [
            'title'      => 'Display Publik',
            'antrian'    => $this->antrianModel->getAntrianDipanggil(),
            'pengaturan' => $this->pengaturanDisplayModel->first(),
        ];

        return view('display/index', $data);
    }

    /**
     * Ambil semua antrian yang aktif (dipanggil)
     */
    public function getAntrian()
    {
        $antrian = $this->antrianModel->getAntrianDipanggil();

        if (!empty($antrian)) {
            foreach ($antrian as &$item) {
                $item['nomor_antrian_display'] = $this->antrianModel->getDisplayNomorAntrian($item['nomor_antrian']);
            }
        }

        return $this->response->setJSON([
            'success' => !empty($antrian),
            'data' => $antrian,
            'message' => !empty($antrian) ? 'Data antrian ditemukan' : 'Belum ada antrian'
        ]);
    }

    /**
     * Ambil antrian berikutnya per kategori
     */
    public function getNextQueue()
    {
        // Get all active categories
        $categories = $this->antrianModel->getActiveCategoriesWithQueues();
        
        $formattedQueues = [];
        foreach ($categories as $category) {
            // Get next 3 waiting queues for each category
            $nextQueues = $this->antrianModel->getNextQueuesByCategory($category['id'], 3);
            
            $categoryQueues = [];
            foreach ($nextQueues as $index => $antrian) {
                $categoryQueues[] = [
                    'nomor_antrian' => $this->antrianModel->getDisplayNomorAntrian($antrian['nomor_antrian']),
                    'waktu_ambil' => $antrian['waktu_ambil'],
                    'position' => $index + 1
                ];
            }
            
            if (!empty($categoryQueues)) {
                $formattedQueues[] = [
                    'kategori' => $category['nama_kategori'],
                    'prefix' => $category['prefix'],
                    'queues' => $categoryQueues
                ];
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $formattedQueues,
            'message' => 'Data antrian berikutnya berhasil dimuat'
        ]);
    }

    /**
     * Ambil statistik antrian
     */
    public function getStatistics()
    {
        $today = date('Y-m-d');
        
        // Get total queues for today
        $total = $this->antrianModel->where('DATE(waktu_ambil)', $today)->countAllResults();
        
        // Get completed queues for today
        $selesai = $this->antrianModel->where('DATE(waktu_ambil)', $today)
                                    ->where('status', 'selesai')
                                    ->countAllResults();
        
        // Get waiting queues
        $menunggu = $this->antrianModel->where('DATE(waktu_ambil)', $today)
                                     ->where('status', 'menunggu')
                                     ->countAllResults();
        
        // Get called queues
        $dipanggil = $this->antrianModel->where('DATE(waktu_ambil)', $today)
                                      ->where('status', 'dipanggil')
                                      ->countAllResults();

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'total' => $total,
                'selesai' => $selesai,
                'menunggu' => $menunggu,
                'dipanggil' => $dipanggil
            ],
            'message' => 'Statistik berhasil dimuat'
        ]);
    }

    /**
     * Ambil pengaturan display dalam bentuk JSON
     */
    public function getPengaturan()
    {
        $pengaturan = $this->pengaturanDisplayModel->first();

        return $this->response->setJSON([
            'status'  => 'success',
            'data'    => $pengaturan ?? null,
            'message' => $pengaturan ? 'Pengaturan ditemukan' : 'Belum ada pengaturan'
        ]);
    }
}