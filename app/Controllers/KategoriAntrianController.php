<?php

namespace App\Controllers;

use App\Models\KategoriAntrianModel;
use CodeIgniter\Controller;

class KategoriAntrianController extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriAntrianModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Kategori Antrian',
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Antrian',
        ];
        return view('admin/kategori/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_kategori' => 'required|max_length[50]',
            'prefix'        => 'required|max_length[5]|is_unique[kategori_antrians.prefix]',
            'deskripsi'     => 'permit_empty|max_length[500]',
            'status'        => 'required|in_list[aktif,nonaktif]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'prefix'        => $this->request->getPost('prefix'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (! $kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kategori dengan ID $id tidak ditemukan");
        }

        $data = [
            'title'    => 'Edit Kategori Antrian',
            'kategori' => $kategori,
        ];
        return view('admin/kategori/edit', $data);
    }

    public function update($id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (! $kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kategori dengan ID $id tidak ditemukan");
        }

        // Validasi dinamis
        $rules = [
            'nama_kategori' => 'required|max_length[50]',
            'deskripsi'     => 'permit_empty|max_length[500]',
            'status'        => 'required|in_list[aktif,nonaktif]',
        ];

        if ($this->request->getPost('prefix') !== $kategori['prefix']) {
            $rules['prefix'] = 'required|max_length[5]|is_unique[kategori_antrians.prefix]';
        } else {
            $rules['prefix'] = 'required|max_length[5]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'prefix'        => $this->request->getPost('prefix'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
