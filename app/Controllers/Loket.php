<?php

namespace App\Controllers;

use App\Models\LoketModel;
use CodeIgniter\Controller;

class Loket extends Controller
{
    protected $loketModel;

    public function __construct()
    {
        $this->loketModel = new LoketModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Loket',
            'lokets' => $this->loketModel->findAll()
        ];
        return view('admin/lokets/index', $data);
    }

    public function create()
    {
        return view('admin/lokets/create');
    }

    public function store()
    {
        $data = [
            'nama_loket' => $this->request->getPost('nama_loket'),
            'kode_loket' => $this->request->getPost('kode_loket'),
            'warna' => $this->request->getPost('warna'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->loketModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->loketModel->errors());
        }

        return redirect()->to('/admin/lokets')->with('success', 'Loket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $loket = $this->loketModel->find($id);
        if (!$loket) {
            return redirect()->to('/admin/lokets')->with('error', 'Loket tidak ditemukan');
        }
        return view('admin/lokets/edit', ['loket' => $loket]);
    }

    public function update($id)
    {
        $data = [
            'nama_loket' => $this->request->getPost('nama_loket'),
            'kode_loket' => $this->request->getPost('kode_loket'),
            'warna' => $this->request->getPost('warna'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->loketModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->loketModel->errors());
        }

        return redirect()->to('/admin/lokets')->with('success', 'Loket berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->loketModel->delete($id);
        return redirect()->to('/admin/lokets')->with('success', 'Loket berhasil dihapus');
    }
}
    