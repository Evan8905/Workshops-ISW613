<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Matriculas::index', ['filter' => 'csrf']);
$routes->post('matriculas', 'Matriculas::guardar', ['filter' => 'csrf']);
$routes->get('matriculas/(:num)', 'Matriculas::comprobante/$1');

$routes->group('cursos', ['filter' => 'csrf'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Cursos::index');
    $routes->get('nuevo', 'Cursos::nuevo');
    $routes->post('/', 'Cursos::guardar');
    $routes->get('(:num)/editar', 'Cursos::editar/$1');
    $routes->post('(:num)', 'Cursos::guardar/$1');
    $routes->post('(:num)/eliminar', 'Cursos::eliminar/$1');
});
