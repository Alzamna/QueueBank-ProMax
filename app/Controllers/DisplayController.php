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
            'antrian'    => $this->antrianModel->getAntrianDipanggil(), // ambil yang status 'dipanggil'
            'pengaturan' => $this->pengaturanDisplayModel->first(),
        ];

        return view('display/index', $data);
    }

    public function getAntrian()
    {
        $antrian = $this->antrianModel->getAntrianDipanggil();

        if (!empty($antrian)) {
            // Use display number for user-friendly format
            $antrian[0]['nomor_antrian'] = $this->antrianModel->getDisplayNomorAntrian($antrian[0]['nomor_antrian']);
            
            // Format loket information
            if (!empty($antrian[0]['nama_loket'])) {
                $antrian[0]['loket'] = $antrian[0]['nama_loket'];
            } else {
                $antrian[0]['loket'] = null;
            }
        }

        return $this->response->setJSON([
            'success' => !empty($antrian),
            'data' => !empty($antrian) ? $antrian[0] : null,
            'message' => !empty($antrian) ? 'Data antrian ditemukan' : 'Belum ada antrian dipanggil'
        ]);
    }

    public function getNextQueue()
    {
        // Get next 3 waiting queues
        $nextQueues = $this->antrianModel->getAntrianAktif();
        
        // Format the data for display
        $formattedQueues = [];
        foreach (array_slice($nextQueues, 0, 3) as $antrian) {
            $formattedQueues[] = [
                'nomor_antrian' => $this->antrianModel->getDisplayNomorAntrian($antrian['nomor_antrian']),
                'kategori' => $antrian['nama_kategori'],
                'waktu_ambil' => $antrian['waktu_ambil']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $formattedQueues,
            'message' => 'Data antrian berikutnya berhasil dimuat'
        ]);
    }

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
