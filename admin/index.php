<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\DocumentAdminController;
use App\Controllers\ProductAdminController;
use App\Controllers\QuoteAdminController;
use App\Core\Auth;

$route = (string) ($_GET['route'] ?? 'dashboard');

if ($route === 'login') {
    (new AuthController())->login();
    return;
}

if ($route === 'authenticate' && is_post()) {
    (new AuthController())->authenticate();
    return;
}

if ($route === 'logout') {
    (new AuthController())->logout();
    return;
}

Auth::requireAdmin();

match ($route) {
    'dashboard' => (new AdminController())->dashboard(),
    'products' => (new ProductAdminController())->index(),
    'products.create' => (new ProductAdminController())->create(),
    'products.store' => (new ProductAdminController())->store(),
    'products.edit' => (new ProductAdminController())->edit(),
    'products.update' => (new ProductAdminController())->update(),
    'products.delete' => (new ProductAdminController())->delete(),
    'products.image.delete' => (new ProductAdminController())->deleteImage(),
    'documents' => (new DocumentAdminController())->index(),
    'documents.store' => (new DocumentAdminController())->store(),
    'documents.toggle' => (new DocumentAdminController())->toggle(),
    'documents.delete' => (new DocumentAdminController())->delete(),
    'quotes' => (new QuoteAdminController())->index(),
    'quotes.show' => (new QuoteAdminController())->show(),
    'quotes.toggle' => (new QuoteAdminController())->toggle(),
    'quotes.delete' => (new QuoteAdminController())->delete(),
    default => (new AdminController())->dashboard(),
};
