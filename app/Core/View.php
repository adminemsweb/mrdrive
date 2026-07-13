<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require app_path('Views/' . $view . '.php');
        $content = ob_get_clean();

        if ($layout) {
            require app_path('Views/' . $layout . '.php');
            return;
        }

        echo $content;
    }
}
