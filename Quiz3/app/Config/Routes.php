<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Cursos::index', ['filter' => 'csrf']);

$routes->group('cursos', ['filter' => 'csrf'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Cursos::index');
    $routes->get('nuevo', 'Cursos::nuevo');
    $routes->post('/', 'Cursos::guardar');
    $routes->get('(:num)/editar', 'Cursos::editar/$1');
    $routes->post('(:num)', 'Cursos::guardar/$1');
    $routes->post('(:num)/eliminar', 'Cursos::eliminar/$1');
});
