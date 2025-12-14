<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================
// PUBLIC ROUTES (TANPA LOGIN)
// ==========================
$routes->get('/', 'Home::index');
$routes->get('menu', 'Home::menu');
$routes->get('menu/json', 'Home::menuJson');
$routes->get('menu/search', 'Menu::search');
$routes->get('about', 'Home::about');

// ==========================
// AUTH (GUEST ONLY)
// ==========================
$routes->get('login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('login', 'AuthController::attempt');

$routes->get('register', 'AuthController::register', ['filter' => 'guest']);
$routes->post('register/save', 'AuthController::attemptRegister');

// ==========================
// LOGOUT (LOGIN REQUIRED)
// ==========================
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);

// ==========================
// CART (LOGIN REQUIRED)
// ==========================
$routes->group('cart', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'Buyer\Cart::index');
    $routes->post('add', 'Buyer\Cart::add');
    $routes->post('update', 'Buyer\Cart::updateQty');
    $routes->post('remove', 'Buyer\Cart::remove');
    $routes->post('clear', 'Buyer\Cart::clear');
    $routes->get('count', 'Buyer\Cart::count');

    // checkout WAJIB verified
    $routes->post('checkout', 'Buyer\Cart::checkout', ['filter' => 'verified']);
});

// ==========================
// PEMBELI (LOGIN + VERIFIED)
// ==========================
$routes->group('p', ['filter' => 'verified'], function ($routes) {

    $routes->get('orders', 'Buyer\Orders::index');
    $routes->get('orders/(:num)', 'Buyer\Orders::show/$1');

    $routes->get('orders/(:num)/nota', 'Buyer\Orders::nota/$1');
    $routes->get('orders/(:num)/nota/pdf', 'Buyer\Orders::notaPdf/$1');

    $routes->get('orders/(:num)/check', 'Buyer\Orders::checkStatus/$1');
    $routes->post('orders/(:num)/delete', 'Buyer\Orders::delete/$1');

    $routes->get('payment/(:num)', 'Buyer\Payment::pay/$1');
    $routes->post('payment/notification', 'Buyer\Payment::notification');
});

// ==========================
// ADMIN (ROLE ADMIN)
// ==========================
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {

    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // menus
    $routes->get('menus', 'Admin\Menus::index');
    $routes->get('menus/create', 'Admin\Menus::create');
    $routes->post('menus/store', 'Admin\Menus::store');
    $routes->get('menus/(:num)/edit', 'Admin\Menus::edit/$1');
    $routes->post('menus/(:num)/update', 'Admin\Menus::update/$1');
    $routes->post('menus/(:num)/delete', 'Admin\Menus::delete/$1');

    // orders
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/(:num)', 'Admin\Orders::show/$1');
    $routes->post('orders/(:num)/status', 'Admin\Orders::updateStatus/$1');
    $routes->post('orders/(:num)/paid', 'Admin\Orders::markPaid/$1');

    // nota
    $routes->get('orders/(:num)/nota', 'Admin\Orders::nota/$1');
    $routes->get('orders/(:num)/nota/pdf', 'Admin\Orders::notaPdf/$1');

    // reports
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/export', 'Admin\Reports::exportCsv');

    // verifikasi WhatsApp
    $routes->get('verify-wa', 'Admin\VerifyWa::index');
    $routes->post('verify-wa/(:num)', 'Admin\VerifyWa::verify/$1');
});
