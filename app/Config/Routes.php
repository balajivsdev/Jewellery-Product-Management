<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('',['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->get('/register', 'AuthController::register');
$routes->post('/register/save', 'AuthController::register_save');
$routes->get('/', 'AuthController::login');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::check_login');
});


$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);


$routes->group('product', ['filter' => 'auth'], function($routes) {
    $routes->get('create', 'Product::create');
    $routes->get('/', 'Product::index');
    $routes->get('edit/(:num)', 'Product::edit/$1'); 
    $routes->post('store', 'Product::store');
    $routes->post('update/(:num)', 'Product::update/$1');
    $routes->post('deleteImage', 'Product::deleteImage');
    $routes->post('fetchProducts', 'Product::fetchProducts');
    $routes->post('delete/(:num)', 'Product::delete/$1');

});






