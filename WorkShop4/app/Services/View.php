<?php

namespace App\Services;

final class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = APP_ROOT . '/app/Views/' . $view . '.php';
        require APP_ROOT . '/app/Views/layouts/header.php';
        require $viewFile;
        require APP_ROOT . '/app/Views/layouts/footer.php';
    }

    public static function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
