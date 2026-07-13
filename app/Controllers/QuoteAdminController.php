<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\QuoteRequest;

final class QuoteAdminController
{
    public function index(): void
    {
        Auth::requireAdmin();
        View::render('admin/quotes/index', ['quotes' => (new QuoteRequest())->all()], 'admin/layout');
    }

    public function show(): void
    {
        Auth::requireAdmin();
        $quote = (new QuoteRequest())->find((int) ($_GET['id'] ?? 0));
        if (!$quote) {
            redirect('/admin/index.php?route=quotes');
        }
        View::render('admin/quotes/show', ['quote' => $quote], 'admin/layout');
    }

    public function toggle(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new QuoteRequest())->toggleRead((int) ($_POST['id'] ?? 0));
        redirect('/admin/index.php?route=quotes');
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new QuoteRequest())->delete((int) ($_POST['id'] ?? 0));
        redirect('/admin/index.php?route=quotes');
    }
}
