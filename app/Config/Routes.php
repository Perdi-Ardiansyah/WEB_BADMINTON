<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

// LOGIN
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// ADMIN
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {
    // DASHBOARD
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // RESERVASI ADMIN
    $routes->get('reservasi', 'Admin\Reservasi::index');
    $routes->get('reservasi/history', 'Admin\Reservasi::history');
    $routes->get('reservasi/history/print', 'Admin\Reservasi::printHistory');
    $routes->get('reservasi/status/(:num)/(:segment)', 'Admin\Reservasi::updateStatus/$1/$2');
    $routes->post('reservasi/selesai/(:num)', 'Admin\Reservasi::selesai/$1');
    $routes->get('reservasi/cleanup', 'Admin\Reservasi::cleanupOldReservations');

    // LAPORAN
    $routes->get('laporan/harian', 'Admin\Laporan::harian');
    $routes->get('laporan/bulanan', 'Admin\Laporan::bulanan');
    // JADWAL LAPANGAN
    $routes->get('jadwal-lapangan', 'Admin\JadwalLapangan::index');
    // AKSI JADWAL LAPANGAN
    $routes->post('jadwal-lapangan/store', 'Admin\JadwalLapangan::store');
    $routes->post('jadwal-lapangan/delete/(:num)', 'Admin\JadwalLapangan::delete/$1');
    $routes->post('jadwal-lapangan/hapus-semua', 'Admin\JadwalLapangan::hapusSemua');
    $routes->post('jadwal-lapangan/hapus-tanggal', 'Admin\JadwalLapangan::hapusByTanggal');
    $routes->post('jadwal-lapangan/generate-satu', 'Admin\JadwalLapangan::generateSatuLapangan');
    $routes->post('jadwal-lapangan/generate-semua', 'Admin\JadwalLapangan::generateSemuaLapangan');

    // PENGGUNA
    $routes->get('pengguna', 'Admin\User::index');
    $routes->get('pengguna/create', 'Admin\User::create');
    $routes->post('pengguna/store', 'Admin\User::store');
    $routes->get('pengguna/edit/(:num)', 'Admin\User::edit/$1');
    $routes->post('pengguna/update/(:num)', 'Admin\User::update/$1');
    $routes->get('pengguna/delete/(:num)', 'Admin\User::delete/$1');

    // PROFILE
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
});

// CLIENT
$routes->group('client', ['filter' => 'userAuth'], function ($routes) {
    $routes->get('dashboard', 'Client\Dashboard::index');
    // RESEVASI CLIENT
    $routes->get('reservasi', 'Client\Reservasi::index');
    $routes->post('reservasi/store', 'Client\Reservasi::store');
    $routes->get('reservasi/history', 'Client\Reservasi::history');
    $routes->post('reservasi/history/delete/(:num)', 'Client\Reservasi::deleteHistory/$1');

    // PROFILE
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
});

// PROFILE
$routes->get('profile', 'Profile::index');
$routes->get('profile/edit', 'Profile::edit');
$routes->post('profile/update', 'Profile::update');

// REGISTER
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::prosesRegister');

// LAPANGAN
$routes->get('/lapangan', 'Lapangan::index');
$routes->post('/lapangan/store', 'Lapangan::store');
$routes->post('/lapangan/update/(:num)', 'Lapangan::update/$1');
$routes->get('/lapangan/delete/(:num)', 'Lapangan::delete/$1');






