<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Home::index');
$routes->get('menu', 'Home::menu');
$routes->get('menu/json', 'Home::menuJson');
$routes->get('about', 'Home::about');

$routes->get('login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('login', 'AuthController::attempt');
$routes->get('logout', 'AuthController::logout');
$routes->get('register', 'AuthController::register');
$routes->post('register/save', 'AuthController::attemptRegister');
$routes->get('register/success', 'AuthController::registerSuccess'); 

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('menus', 'Admin\Menus::index'); 
});

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {

    $routes->get('/', 'Admin\Menus::index');
    $routes->get('menus', 'Admin\Menus::index');
    $routes->get('menus/create', 'Admin\Menus::create');
    $routes->post('menus/store', 'Admin\Menus::store');
    $routes->get('menus/(:num)/edit', 'Admin\Menus::edit/$1');
    $routes->post('menus/(:num)/update', 'Admin\Menus::update/$1');
    $routes->post('menus/(:num)/delete', 'Admin\Menus::delete/$1');

    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/export', 'Admin\Reports::exportCsv'); 
});

$routes->group('cart', function ($routes) {
    $routes->get('/', 'Buyer\Cart::index');
    $routes->post('add', 'Buyer\Cart::add');
    $routes->post('update', 'Buyer\Cart::updateQty');
    $routes->post('remove', 'Buyer\Cart::remove');
    $routes->post('clear', 'Buyer\Cart::clear');
    $routes->get('count', 'Buyer\Cart::count');

    $routes->post('checkout', 'Buyer\Cart::checkout');
});

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Admin\Menus::index');
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/(:num)', 'Admin\Orders::show/$1');
    $routes->post('orders/(:num)/status', 'Admin\Orders::updateStatus/$1');

    $routes->post('orders/(:num)/paid', 'Admin\Orders::markPaid/$1');
});

$routes->group('p', ['filter' => 'role:pembeli'], function ($routes) {
    $routes->get('orders', 'Buyer\Orders::index', ['filter' => 'role:pembeli']);
    $routes->get('orders/(:num)', 'Buyer\Orders::show/$1', ['filter' => 'role:pembeli']);

    $routes->post('orders/(:num)/delete', 'Buyer\Orders::delete/$1');
    $routes->delete('orders/(:num)/delete', 'Buyer\Orders::delete/$1');

    $routes->get('payment/(:num)', 'Buyer\Payment::pay/$1');
    $routes->post('payment/notification', 'Buyer\Payment::notification');
});

$routes->get('menu/search', 'Menu::search');
$routes->get('login',  'AuthController::login');
$routes->post('login', 'AuthController::attempt');

$routes->get('logout', 'AuthController::logout');

$routes->get('register',  'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('register/success', 'AuthController::registerSuccess');
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('cart', 'Cart::index');
    $routes->get('user/profile', 'User::profile');
});
