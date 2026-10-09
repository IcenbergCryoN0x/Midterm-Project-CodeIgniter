<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Home and Authentication
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->post('/logout', 'Auth::logout');

// // Dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// // Product Management
$routes->get('/products', 'Products::index', ['filter' => 'auth']);
$routes->get('/products/new', 'Products::newProduct', ['filter' => 'auth']);
$routes->post('/products/create', 'Products::create', ['filter' => 'auth']);
$routes->get('/products/edit/(:num)', 'Products::edit/$1', ['filter' => 'auth']);
$routes->post('/products/update/(:num)', 'Products::update/$1', ['filter' => 'auth']);
$routes->post('/products/delete/(:num)', 'Products::delete/$1', ['filter' => 'auth']);

// // Customer Management
$routes->get('/customers', 'Customers::index', ['filter' => 'auth']);
$routes->get('/customers/new', 'Customers::newCustomer', ['filter' => 'auth']);
$routes->post('/customers/create', 'Customers::create', ['filter' => 'auth']);
$routes->get('/customers/edit/(:num)', 'Customers::edit/$1', ['filter' => 'auth']);
$routes->post('/customers/update/(:num)', 'Customers::update/$1', ['filter' => 'auth']);
$routes->post('/customers/delete/(:num)', 'Customers::delete/$1', ['filter' => 'auth']);

// // Staff Management
$routes->get('/staff', 'Staff::index', ['filter' => 'auth']);
$routes->get('/staff/new', 'Staff::newStaff', ['filter' => 'auth']);
$routes->post('/staff/create', 'Staff::create', ['filter' => 'auth']);
$routes->get('/staff/edit/(:num)', 'Staff::edit/$1', ['filter' => 'auth']);
$routes->post('/staff/update/(:num)', 'Staff::update/$1', ['filter' => 'auth']);
$routes->post('/staff/delete/(:num)', 'Staff::delete/$1', ['filter' => 'auth']);

// // Sales
$routes->get('/sales', 'Sales::index', ['filter' => 'auth']);
$routes->get('/sales/new', 'Sales::newSale', ['filter' => 'auth']);
$routes->post('/sales/create', 'Sales::create', ['filter' => 'auth']);

// Optional: Individual Sale Details
$routes->get('/sales/(:num)', 'Sales::show/$1', ['filter' => 'auth']);
