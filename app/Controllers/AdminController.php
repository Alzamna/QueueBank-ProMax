<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoketModel;
use App\Models\KategoriAntrianModel;
use App\Models\AntrianModel;
use App\Models\PengaturanDisplayModel;
use App\Models\PenggunaModel;
use App\Models\UserKategoriModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $loketModel;
    protected $kategoriAntrianModel;
    protected $antrianModel;
    protected $pengaturanDisplayModel;
    protected $penggunaModel;
    protected $userKategoriModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->loketModel = new LoketModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
        $this->antrianModel = new AntrianModel();
        $this->pengaturanDisplayModel = new PengaturanDisplayModel();
        $this->penggunaModel = new PenggunaModel();
        $this->userKategoriModel = new UserKategoriModel();
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
            'pengguna' => $this->userModel->countAll(),

        ];

        return view('admin/dashboard', $data);
    }

    public function pengguna()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->findAll(),
        ];

        return view('admin/pengguna/pengguna', $data);
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

    public function userKategori()
    {
        $data = [
            'title' => 'Kelola Kategori Pengguna',
            'users' => $this->userModel->where('role', 'petugas')->findAll(),
            'kategori' => $this->kategoriAntrianModel->where('status', 'aktif')->findAll(),
            'userKategori' => $this->userKategoriModel->getAllUserKategori(),
        ];

        return view('admin/user_kategori/index', $data);
    }

    public function assignKategori()
    {
        if ($this->request->getMethod() === 'post') {
            $user_id = $this->request->getPost('user_id');
            $kategori_ids = $this->request->getPost('kategori_ids');

            if ($this->userKategoriModel->assignCategoriesToUser($user_id, $kategori_ids)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kategori berhasil ditugaskan ke pengguna'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menugaskan kategori ke pengguna'
                ]);
                }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
    }

    public function getUserKategori($user_id)
    {
        $userKategori = $this->userKategoriModel->getCategoriesByUserId($user_id);
        
        return $this->response->setJSON([
            'success' => true,
            'userKategori' => $userKategori
        ]);
    }
}
