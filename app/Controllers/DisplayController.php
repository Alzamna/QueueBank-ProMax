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

        return $this->response->setJSON([
            'success' => !empty($antrian),
            'data' => !empty($antrian) ? $antrian[0] : null,
            'message' => !empty($antrian) ? 'Data antrian ditemukan' : 'Belum ada antrian dipanggil'
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
