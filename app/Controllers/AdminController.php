<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Product;
use App\Models\QuoteRequest;

final class AdminController
{
    public function dashboard(): void
    {
        Auth::requireAdmin();
        View::render('admin/dashboard', [
            'stats' => (new Product())->stats(),
            'quotes' => [
                'total' => (new QuoteRequest())->count(),
                'unread' => (new QuoteRequest())->unreadCount(),
            ],
        ], 'admin/layout');
    }
}
