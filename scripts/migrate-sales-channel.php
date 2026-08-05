<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Core\Database;

$database = Database::connection();
$column = $database->query("SHOW COLUMNS FROM products LIKE 'sale_channel'")->fetch();

if (!$column) {
    $database->exec(
        "ALTER TABLE products ADD COLUMN sale_channel ENUM('whatsapp', 'cart', 'both') NOT NULL DEFAULT 'whatsapp' AFTER compare_at_price"
    );
    echo "sale_channel added\n";
    exit(0);
}

echo "sale_channel already exists\n";
