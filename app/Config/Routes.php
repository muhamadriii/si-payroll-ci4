<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');

$routes->group('', ['namespace' => 'App\\Controllers'], function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
    $routes->get('users', 'Users::index', ['filter' => 'auth']);
    $routes->get('users/create', 'Users::create', ['filter' => 'auth']);
    $routes->post('users/store', 'Users::store', ['filter' => 'auth']);
    $routes->get('users/(:segment)/edit', 'Users::edit/$1', ['filter' => 'auth']);
    $routes->post('users/(:segment)/update', 'Users::update/$1', ['filter' => 'auth']);
    $routes->post('users/(:segment)/delete', 'Users::delete/$1', ['filter' => 'auth']);
    $routes->get('positions', 'Positions::index', ['filter' => 'auth']);
    $routes->get('positions/create', 'Positions::create', ['filter' => 'auth']);
    $routes->post('positions/store', 'Positions::store', ['filter' => 'auth']);
    $routes->post('positions/datatable', 'Positions::datatable', ['filter' => 'auth']);
    $routes->get('positions/(:segment)/edit', 'Positions::edit/$1', ['filter' => 'auth']);
    $routes->post('positions/(:segment)/update', 'Positions::update/$1', ['filter' => 'auth']);
    $routes->post('positions/(:segment)/delete', 'Positions::delete/$1', ['filter' => 'auth']);
    $routes->get('deductions', 'SalaryDeductions::index', ['filter' => 'auth']);
    $routes->get('deductions/create', 'SalaryDeductions::create', ['filter' => 'auth']);
    $routes->post('deductions/store', 'SalaryDeductions::store', ['filter' => 'auth']);
    $routes->get('deductions/(:segment)/edit', 'SalaryDeductions::edit/$1', ['filter' => 'auth']);
    $routes->post('deductions/(:segment)/update', 'SalaryDeductions::update/$1', ['filter' => 'auth']);
    $routes->post('deductions/(:segment)/delete', 'SalaryDeductions::delete/$1', ['filter' => 'auth']);
    $routes->get('attendance', 'Attendance::index', ['filter' => 'auth']);
    $routes->get('attendance/create', 'Attendance::create', ['filter' => 'auth']);
    $routes->post('attendance/store', 'Attendance::store', ['filter' => 'auth']);
    $routes->get('attendance/edit', 'Attendance::edit', ['filter' => 'auth']);
    $routes->post('attendance/update', 'Attendance::update', ['filter' => 'auth']);
    $routes->get('attendance/report', 'Attendance::report', ['filter' => 'auth']);
    $routes->get('attendance/export', 'Attendance::export', ['filter' => 'auth']);
    $routes->get('salaries', 'Salaries::index', ['filter' => 'auth']);
    $routes->post('salaries/calculate', 'Salaries::calculate', ['filter' => 'auth']);
    $routes->get('salaries/report', 'Salaries::report', ['filter' => 'auth']);
    $routes->get('salaries/slip-report', 'Salaries::slipReport', ['filter' => 'auth']);
    $routes->get('salaries/slip-export', 'Salaries::slipExport', ['filter' => 'auth']);
    $routes->get('salaries/slip/(:segment)', 'Salaries::slip/$1', ['filter' => 'auth']);
    $routes->get('salaries/export', 'Salaries::export', ['filter' => 'auth']);
    $routes->get('profile', 'Profile::index', ['filter' => 'auth']);
    $routes->post('profile/update', 'Profile::update', ['filter' => 'auth']);
    $routes->get('assets/sbadmin2/(.*)', 'Assets::sbadmin2/$1');
});
