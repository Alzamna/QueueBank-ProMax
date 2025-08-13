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

    public function index()
    {
        $data = [
            'title' => 'Display Publik',
            'antrian' => $this->antrianModel->getAntrianAktif(),
            'pengaturan' => $this->pengaturanDisplayModel->first(),
        ];

        return view('display/index', $data);
    }

    public function getAntrian()
    {
        $antrian = $this->antrianModel->getAntrianAktif();
        return $this->response->setJSON($antrian);
    }

    public function getPengaturan()
    {
        $pengaturan = $this->pengaturanDisplayModel->first();
        return $this->response->setJSON($pengaturan);
    }
}
