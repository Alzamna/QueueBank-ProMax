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
        // Fetch all queues that are either called or waiting
        $antrian = $this->antrianModel->getAntrianDipanggil(); // Get called queues
        $allAntrian = $this->antrianModel->getAllAntrian(); // Create a new method to get all queues

        return $this->response->setJSON([
            'success' => !empty($allAntrian),
            'data' => $allAntrian,
            'message' => !empty($allAntrian) ? 'Data antrian ditemukan' : 'Belum ada antrian'
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
