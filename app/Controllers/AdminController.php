<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoketModel;
use App\Models\KategoriAntrianModel;
use App\Models\AntrianModel;
use App\Models\PengaturanDisplayModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $loketModel;
    protected $kategoriAntrianModel;
    protected $antrianModel;
    protected $pengaturanDisplayModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->loketModel = new LoketModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
        $this->antrianModel = new AntrianModel();
        $this->pengaturanDisplayModel = new PengaturanDisplayModel();
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'totalUsers' => $this->userModel->countAll(),
            'totalLokets' => $this->loketModel->countAll(),
            'totalKategori' => $this->kategoriAntrianModel->countAll(),
            'totalAntrianHariIni' => $this->antrianModel->where('DATE(antrians.waktu_ambil)', date('Y-m-d'))->countAllResults(),
            'statistik' => $this->antrianModel->getStatistikHarian(),
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->findAll(),
        ];

        return view('admin/users/index', $data);
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
        $data = [
            'title' => 'Laporan',
            'statistik' => $this->antrianModel->getStatistikHarian(),
        ];

        return view('admin/laporan/index', $data);
    }
}
