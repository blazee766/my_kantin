<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Home::index');
$routes->get('menu', 'Home::menu');
$routes->get('menu/json', 'Home::menuJson');

// Auth
$routes->get('login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('login', 'AuthController::attempt');
$routes->get('logout', 'AuthController::logout');
// Auth (lanjutan)
$routes->get('register', 'AuthController::register');
$routes->post('register/save', 'AuthController::attemptRegister');
$routes->get('register/success', 'AuthController::registerSuccess'); // ← tambahkan ini

// Admin area (contoh dashboard)
$routes->group('admin', ['filter' => 'role:admin'], function($routes){
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('menus', 'Admin\Menus::index'); // tahap 3-4 nanti CRUD
});

// --- ADMIN: MENU CRUD + LAPORAN ---
$routes->group('admin', ['filter' => 'role:admin'], function($routes){
    // MENUS CRUD
    $routes->get('/', 'Admin\Menus::index');  
    $routes->get('menus', 'Admin\Menus::index');
    $routes->get('menus/create', 'Admin\Menus::create');
    $routes->post('menus/store', 'Admin\Menus::store');
    $routes->get('menus/(:num)/edit', 'Admin\Menus::edit/$1');
    $routes->post('menus/(:num)/update', 'Admin\Menus::update/$1');
    $routes->post('menus/(:num)/delete', 'Admin\Menus::delete/$1');

    // REPORTS
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/export', 'Admin\Reports::exportCsv'); // ?from=YYYY-MM-DD&to=YYYY-MM-DD
});

// Cart: tambah endpoint count (untuk badge header)
$routes->group('cart', function($routes){
    $routes->get('/', 'Buyer\Cart::index');
    $routes->post('add', 'Buyer\Cart::add');
    $routes->post('update', 'Buyer\Cart::updateQty');
    $routes->post('remove', 'Buyer\Cart::remove');
    $routes->post('clear', 'Buyer\Cart::clear');
    $routes->get('count', 'Buyer\Cart::count');

    // >>> WAJIB: ini yang hilang
    $routes->post('checkout', 'Buyer\Cart::checkout');
});

// Admin: status order
$routes->group('admin', ['filter' => 'role:admin'], function($routes){
    $routes->get('/', 'Admin\Menus::index');
    // orders (sudah ada index & show dari Tahap 3)
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/(:num)', 'Admin\Orders::show/$1');
    $routes->post('orders/(:num)/status', 'Admin\Orders::updateStatus/$1');
});

// Pembeli area (contoh halaman pesanan nanti)
$routes->group('p', ['filter' => 'role:pembeli'], function($routes){
$routes->get('orders', 'Buyer\Orders::index', ['filter' => 'role:pembeli']);
$routes->get('orders/(:num)', 'Buyer\Orders::show/$1', ['filter' => 'role:pembeli']);

 $routes->post('orders/(:num)/delete', 'Buyer\Orders::delete/$1');
 $routes->delete('orders/(:num)/delete', 'Buyer\Orders::delete/$1');
});
// ... route kamu yang lain tetap
$routes->get('menu/search', 'Menu::search');   // endpoint AJAX pencarian menu
$routes->get('login',  'AuthController::login');
$routes->post('login', 'AuthController::attempt');

$routes->get('logout', 'AuthController::logout');

$routes->get('register',  'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('register/success', 'AuthController::registerSuccess');
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('cart', 'Cart::index');
    $routes->get('user/profile', 'User::profile');
});
