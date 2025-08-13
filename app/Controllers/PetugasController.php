<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;
use App\Models\LoketModel;

class PetugasController extends BaseController
{
    protected $antrianModel;
    protected $kategoriAntrianModel;
    protected $loketModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
        $this->loketModel = new LoketModel();
    }

    public function dashboard()
    {
        $petugas_id = session()->get('user_id');
        $loket_id = $this->request->getGet('loket_id') ?? null;

        $data = [
            'title' => 'Dashboard Petugas',
            'kategori' => $this->kategoriAntrianModel->findAll(),
            'lokets' => $this->loketModel->where('status', 'aktif')->findAll(),
            'antrian_aktif' => $this->antrianModel->getAntrianAktif(),
            'antrian_dipanggil' => $this->antrianModel->getAntrianDipanggil($loket_id),
            'sisa_antrian' => $this->antrianModel->where('status', 'menunggu')->countAllResults(),
        ];

        return view('petugas/dashboard', $data);
    }

    public function panggilAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');
            $loket_id = $this->request->getPost('loket_id');
            $petugas_id = session()->get('user_id');

            $antrian = $this->antrianModel->find($antrian_id);
            if ($antrian && $antrian['status'] === 'menunggu') {
                $this->antrianModel->update($antrian_id, [
                    'loket_id' => $loket_id,
                    'petugas_id' => $petugas_id,
                    'status' => 'dipanggil',
                    'waktu_panggil' => date('Y-m-d H:i:s'),
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Antrian berhasil dipanggil',
                    'nomor_antrian' => $antrian['nomor_antrian'],
                    'loket' => $this->loketModel->find($loket_id)['nama_loket'] ?? 'Loket ' . $loket_id
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memanggil antrian']);
    }

    public function selesaiAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');

            $antrian = $this->antrianModel->find($antrian_id);
            if ($antrian && $antrian['status'] === 'dipanggil') {
                $this->antrianModel->update($antrian_id, [
                    'status' => 'selesai',
                    'waktu_selesai' => date('Y-m-d H:i:s'),
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Antrian selesai dilayani'
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyelesaikan antrian']);
    }

    public function lewatiAntrian()
    {
        if ($this->request->getMethod() === 'post') {
            $antrian_id = $this->request->getPost('antrian_id');

            $antrian = $this->antrianModel->find($antrian_id);
            if ($antrian && $antrian['status'] === 'dipanggil') {
                $this->antrianModel->update($antrian_id, [
                    'status' => 'lewati',
                    'waktu_selesai' => date('Y-m-d H:i:s'),
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Antrian dilewati'
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal melewati antrian']);
    }
}
