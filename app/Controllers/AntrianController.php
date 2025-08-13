<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;

class AntrianController extends BaseController
{
    protected $antrianModel;
    protected $kategoriAntrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->kategoriAntrianModel = new KategoriAntrianModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Ambil Nomor Antrian',
            'kategori' => $this->kategoriAntrianModel->where('status', 'aktif')->findAll(),
        ];

        return view('antrian/index', $data);
    }

    public function ambilNomor()
    {
        if ($this->request->getMethod() === 'post') {
            $kategori_id = $this->request->getPost('kategori_id');

            $nomor_antrian = $this->antrianModel->getNextNomorAntrian($kategori_id);
            if (!$nomor_antrian) {
                return $this->response->setJSON(['success' => false, 'message' => 'Kategori tidak valid']);
            }

            $data = [
                'nomor_antrian' => $nomor_antrian,
                'kategori_id' => $kategori_id,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d H:i:s'),
            ];

            $antrian_id = $this->antrianModel->insert($data);

            if ($antrian_id) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Nomor antrian berhasil diambil',
                    'nomor_antrian' => $nomor_antrian,
                    'antrian_id' => $antrian_id
                ]);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengambil nomor antrian']);
    }

    public function cekStatus($nomor_antrian = null)
    {
        if ($nomor_antrian) {
            $antrian = $this->antrianModel
                ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix')
                ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
                ->where('antrians.nomor_antrian', $nomor_antrian)
                ->first();

            if ($antrian) {
                $antrian_sebelumnya = $this->antrianModel
                    ->where('kategori_id', $antrian['kategori_id'])
                    ->where('status', 'menunggu')
                    ->where('id <', $antrian['id'])
                    ->countAllResults();

                $antrian['sisa_antrian'] = $antrian_sebelumnya;
                return $this->response->setJSON($antrian);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Nomor antrian tidak ditemukan']);
    }
}
