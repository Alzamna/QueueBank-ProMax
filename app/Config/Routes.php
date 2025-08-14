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
    $routes->get('users', 'AdminController::users');
    $routes->get('lokets', 'AdminController::lokets');
    $routes->get('kategori', 'AdminController::kategoriAntrian');
    $routes->get('pengaturan', 'AdminController::pengaturan');
    $routes->get('laporan', 'AdminController::laporan');
});

// Petugas Routes
$routes->group('petugas', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'PetugasController::dashboard');
    $routes->post('panggil-antrian', 'PetugasController::panggilAntrian');
    $routes->post('selesai-antrian', 'PetugasController::selesaiAntrian');
    $routes->post('lewati-antrian', 'PetugasController::lewatiAntrian');
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
