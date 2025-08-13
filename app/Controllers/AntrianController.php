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
        $kategori = $this->kategoriAntrianModel->where('status', 'aktif')->findAll();
        
        // Debug information
        log_message('debug', 'Index method called');
        log_message('debug', 'Categories found: ' . json_encode($kategori));
        
        $data = [
            'title' => 'Ambil Nomor Antrian',
            'kategori' => $kategori,
        ];

        return view('antrian/index', $data);
    }

    public function ambilNomor()
    {
        // Debug information
        log_message('debug', 'AmbilNomor method called');
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        log_message('debug', 'Request headers: ' . json_encode($this->request->getHeaders()));
        log_message('debug', 'Request body: ' . json_encode($this->request->getBody()));
        
        if ($this->request->getMethod() === 'POST') {
            $kategori_id = $this->request->getPost('kategori_id');
            
            log_message('debug', 'Kategori ID received: ' . $kategori_id);
            
            // Validate kategori_id
            if (!$kategori_id || !is_numeric($kategori_id)) {
                log_message('error', 'Invalid kategori_id: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'ID kategori tidak valid'
                ]);
            }

            // Check if kategori exists and is active
            $kategori = $this->kategoriAntrianModel->where('id', $kategori_id)
                                                   ->where('status', 'aktif')
                                                   ->first();
            if (!$kategori) {
                log_message('error', 'Kategori not found or inactive: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Kategori tidak ditemukan atau tidak aktif'
                ]);
            }

            $nomor_antrian = $this->antrianModel->getNextNomorAntrian($kategori_id);
            if (!$nomor_antrian) {
                log_message('error', 'Failed to generate nomor antrian for kategori: ' . $kategori_id);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal generate nomor antrian'
                ]);
            }

            $data = [
                'nomor_antrian' => $nomor_antrian,
                'kategori_id' => $kategori_id,
                'status' => 'menunggu',
                'waktu_ambil' => date('Y-m-d H:i:s'),
            ];

            $antrian_id = $this->antrianModel->insert($data);

            if ($antrian_id) {
                // Calculate queue position (how many people are ahead)
                $antrian_sebelumnya = $this->antrianModel
                    ->where('kategori_id', $kategori_id)
                    ->where('status', 'menunggu')
                    ->where('id <', $antrian_id)
                    ->countAllResults();
                
                log_message('info', 'Successfully created antrian: ' . $antrian_id . ' with nomor: ' . $nomor_antrian);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Nomor antrian berhasil diambil',
                    'nomor_antrian' => $nomor_antrian,
                    'antrian_id' => $antrian_id,
                    'kategori' => $kategori['nama_kategori'],
                    'posisi_antrian' => $antrian_sebelumnya
                ]);
            } else {
                log_message('error', 'Failed to insert antrian data');
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal menyimpan data antrian'
                ]);
            }
        }

        log_message('error', 'Invalid request method: ' . $this->request->getMethod());
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Method tidak valid. Expected POST, got ' . $this->request->getMethod()
        ]);
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
