<?php

declare(strict_types=1);

function start_app_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
}

function require_login(string $redirectPath): void
{
    if (!is_logged_in()) {
        header('Location: ' . $redirectPath . '?error=session_required');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
