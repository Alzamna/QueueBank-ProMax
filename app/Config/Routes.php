<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('pengguna/pengguna', 'Admin\PenggunaController::index');
    $routes->get('users', 'AdminController::users');
    $routes->get('kategori', 'AdminController::kategoriAntrian');
    $routes->get('pengaturan', 'AdminController::pengaturan');
    $routes->get('laporan', 'AdminController::laporan');

    $routes->get('lokets', 'Loket::index');
    $routes->get('lokets/create', 'Loket::create');
    $routes->post('lokets/store', 'Loket::store');
    $routes->get('lokets/edit/(:num)', 'Loket::edit/$1');
    $routes->post('lokets/update/(:num)', 'Loket::update/$1');
    $routes->post('lokets/delete/(:num)', 'Loket::delete/$1');

    $routes->get('kategori', 'KategoriAntrianController::index');
    $routes->get('kategori/create', 'KategoriAntrianController::create');
    $routes->post('kategori/store', 'KategoriAntrianController::store');
    $routes->get('kategori/edit/(:num)', 'KategoriAntrianController::edit/$1');
    $routes->post('kategori/update/(:num)', 'KategoriAntrianController::update/$1');
    $routes->get('kategori/delete/(:num)', 'KategoriAntrianController::delete/$1');
});

// Petugas Routes
$routes->group('petugas', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'PetugasController::dashboard');
    $routes->post('panggil-antrian', 'PetugasController::panggilAntrian');
    $routes->post('selesai-antrian', 'PetugasController::selesaiAntrian');
    $routes->post('lewati-antrian', 'PetugasController::lewatiAntrian');
});

// Pengguna Routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('pengguna', 'Admin\PenggunaController::index');
    $routes->post('pengguna/add', 'Admin\PenggunaController::add');
    $routes->get('pengguna/delete/(:num)', 'Admin\PenggunaController::delete/$1');
});


// Display Routes
$routes->get('display', 'DisplayController::index');
$routes->get('display/antrian', 'DisplayController::getAntrian');
$routes->get('display/pengaturan', 'DisplayController::getPengaturan');

// Antrian Routes
$routes->get('antrian', 'AntrianController::index');
$routes->get('antrian/desktop', 'AntrianController::desktop');
$routes->get('antrian/mobile', 'AntrianController::mobile');
$routes->get('antrian/test', 'AntrianController::test');
$routes->post('ambil-nomor', 'AntrianController::ambilNomor');
$routes->get('cek-status/(:any)', 'AntrianController::cekStatus/$1');
$routes->get('cek-status-mobile', 'AntrianController::cekStatusMobile');
$routes->get('statistik-antrian', 'AntrianController::getStatistikAntrian');
$routes->get('today-summary', 'AntrianController::getTodaySummary');
$routes->get('cleanup-old-data', 'AntrianController::cleanupOldData');

// Desktop Routes (Mesin Antrian)
$routes->get('desktop', 'DesktopController::index');
$routes->post('desktop/ambilNomorDesktop', 'DesktopController::ambilNomorDesktop');
$routes->get('desktop/getStatistikHarian', 'DesktopController::getStatistikHarian');
