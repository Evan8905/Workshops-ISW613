<?php

declare(strict_types=1);

define('APP_ROOT', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $file = APP_ROOT . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use App\Controllers\AuthController;
use App\Controllers\CourseController;
use App\Controllers\DashboardController;
use App\Controllers\ProfileController;
use App\Controllers\UserController;

$route = $_GET['route'] ?? 'login';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$routes = [
    'GET' => [
        'login' => [AuthController::class, 'showLogin'],
        'register' => [AuthController::class, 'showRegister'],
        'dashboard' => [DashboardController::class, 'index'],
        'profile' => [ProfileController::class, 'show'],
        'courses' => [CourseController::class, 'index'],
        'course-create' => [CourseController::class, 'create'],
        'course-edit' => [CourseController::class, 'edit'],
        'users' => [UserController::class, 'index'],
    ],
    'POST' => [
        'login' => [AuthController::class, 'login'],
        'register' => [AuthController::class, 'register'],
        'logout' => [AuthController::class, 'logout'],
        'profile' => [ProfileController::class, 'update'],
        'course-save' => [CourseController::class, 'save'],
        'course-delete' => [CourseController::class, 'delete'],
    ],
];

if (!is_string($route) || !isset($routes[$method][$route])) {
    http_response_code(404);
    exit('Page not found.');
}

[$controller, $action] = $routes[$method][$route];
(new $controller())->$action();
