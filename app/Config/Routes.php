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
    $routes->get('user-kategori', 'AdminController::userKategori');
    $routes->post('assign-kategori', 'AdminController::assignKategori');
    $routes->get('get-user-kategori/(:num)', 'AdminController::getUserKategori/$1');

    // Pengguna Routes
    $routes->get('pengguna', 'Admin\PenggunaController::index');
    $routes->post('pengguna/add', 'AdminController::addPengguna');
    $routes->get('pengguna/edit/(:num)', 'Admin\PenggunaController::edit/$1');
    $routes->match(['get', 'post'], 'pengguna/update/(:num)', 'AdminController::updatePengguna/$1');
    $routes->get('pengguna/delete/(:num)', 'AdminController::deletePengguna/$1');

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
    $routes->get('dashboard/(:num)', 'PetugasController::dashboardKategori/$1');
    $routes->post('panggil-antrian', 'PetugasController::panggilAntrian');
    $routes->post('selesai-antrian', 'PetugasController::selesaiAntrian');
    $routes->post('lewati-antrian', 'PetugasController::lewatiAntrian');
    $routes->get('get-antrian-by-kategori/(:num)', 'PetugasController::getAntrianByKategori/$1');
    $routes->get('get-dashboard-summary', 'PetugasController::getDashboardSummary');
    $routes->get('get-statistik-real-time', 'PetugasController::getStatistikRealTime');
    $routes->get('get-kategori-info', 'PetugasController::getKategoriInfo');
    $routes->get('debug-user-access', 'PetugasController::debugUserAccess');
    $routes->get('test-system', 'PetugasController::testSystem');
    $routes->match(['get', 'post'], 'test-panggil-antrian', 'PetugasController::testPanggilAntrian');
    $routes->match(['get', 'post'], 'test-selesai-antrian', 'PetugasController::testSelesaiAntrian');
    $routes->match(['get', 'post'], 'test-lewati-antrian', 'PetugasController::testLewatiAntrian');
    $routes->post('panggil-ulang-antrian', 'PetugasController::panggilUlangAntrian');
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

// Cleanup Routes (Admin only)
$routes->group('cleanup', ['filter' => 'auth'], function($routes) {
    $routes->post('antrian', 'CleanupController::cleanupAntrian');
    $routes->post('antrian/(:any)', 'CleanupController::cleanupAntrianByDate/$1');
});
