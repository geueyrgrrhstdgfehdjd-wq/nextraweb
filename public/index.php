<?php
session_start();
require_once __DIR__ . '/../config/app.php';

spl_autoload_register(function ($class) {
    $file = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\TopupController;
use App\Controllers\AdminController;

$router = new Router();

// หน้าบ้าน
$router->get('/', [HomeController::class, 'index']);
$router->get('/topup', [TopupController::class, 'index']);
$router->post('/topup/truemoney', [TopupController::class, 'processTruemoney']);

// หลังบ้าน
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin/settings/update', [AdminController::class, 'updateSettings']);
$router->post('/admin/product/store', [AdminController::class, 'storeProduct']);
$router->post('/admin/product/delete', [AdminController::class, 'deleteProduct']);

$router->dispatch($_SERVER['REQUEST_URI']);
