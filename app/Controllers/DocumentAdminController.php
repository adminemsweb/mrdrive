<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Upload;
use App\Core\View;
use App\Models\Document;

final class DocumentAdminController
{
    public function index(): void
    {
        Auth::requireAdmin();
        View::render('admin/documents', ['documents' => (new Document())->all()], 'admin/layout');
    }

    public function store(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        $path = Upload::file($_FILES['file_path'] ?? [], 'pdf', 'documents');
        if ($path) {
            (new Document())->create([
                'name' => trim((string) ($_POST['name'] ?? '')),
                'type' => trim((string) ($_POST['type'] ?? 'catalogo')),
                'file_path' => $path,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
        }
        redirect('/admin/index.php?route=documents');
    }

    public function toggle(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new Document())->toggle((int) ($_POST['id'] ?? 0));
        redirect('/admin/index.php?route=documents');
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new Document())->delete((int) ($_POST['id'] ?? 0));
        redirect('/admin/index.php?route=documents');
    }
}
