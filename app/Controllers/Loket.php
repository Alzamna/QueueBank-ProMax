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
    $loket = $this->loketModel->find($id);
    if (! $loket) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Loket dengan ID $id tidak ditemukan");
    }

    // Atur rules dinamis
    $rules = [
        'nama_loket' => 'required|max_length[50]',
        'warna'      => 'required|max_length[7]',
        'status'     => 'required|in_list[aktif,nonaktif]',
    ];

    // Kalau kode_loket berubah, cek unik
    if ($this->request->getPost('kode_loket') !== $loket['kode_loket']) {
        $rules['kode_loket'] = 'required|max_length[10]|is_unique[lokets.kode_loket]';
    } else {
        $rules['kode_loket'] = 'required|max_length[10]';
    }

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->loketModel->update($id, [
        'nama_loket' => $this->request->getPost('nama_loket'),
        'kode_loket' => $this->request->getPost('kode_loket'),
        'warna'      => $this->request->getPost('warna'),
        'status'     => $this->request->getPost('status'),
    ]);

    return redirect()->to('/admin/lokets')->with('success', 'Loket berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->loketModel->delete($id);
        return redirect()->to('/admin/lokets')->with('success', 'Loket berhasil dihapus');
    }
}
