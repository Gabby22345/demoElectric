<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); 
$routes->get('/about', 'About::index'); 
$routes->get('/services', 'Services::index'); 
$routes->match(['get', 'post'], '/contact', 'Contact::index'); 
$routes->get('/register', 'Register::index'); 
$routes->post('/register', 'Register::create'); 

// Authentication and customer-account management
$routes->match(['get', 'post'], '/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/accounts/new', 'Dashboard::new');
$routes->post('/accounts', 'Dashboard::create');
$routes->get('/accounts/edit/(:num)', 'Dashboard::edit/$1');
$routes->post('/accounts/update/(:num)', 'Dashboard::update/$1');
$routes->post('/accounts/delete/(:num)', 'Dashboard::delete/$1');

