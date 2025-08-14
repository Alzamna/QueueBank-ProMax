<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\KategoriAntrianModel;

class HomeController extends BaseController
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
        return view('home');
    }
}
