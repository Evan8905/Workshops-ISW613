<?php

namespace App\Services;

final class Session
{
    private const TIMEOUT_SECONDS = 1800;
    public const REMEMBER_COOKIE = 'remembered_username';

    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::start();
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'username' => $user['username'],
            'province_id' => $user['province_id'] === null ? null : (int) $user['province_id'],
            'province_name' => $user['province_name'],
            'profile_picture' => $user['profile_picture'],
        ];
        $_SESSION['last_activity'] = time();
    }

    public static function user(): ?array
    {
        self::start();
        return $_SESSION['user'] ?? null;
    }

    public static function requireUser(): array
    {
        self::start();
        if (!isset($_SESSION['user'])) {
            self::redirect('login', 'error', 'login_required');
        }
        if (time() - ($_SESSION['last_activity'] ?? 0) > self::TIMEOUT_SECONDS) {
            self::logout();
            self::redirect('login', 'error', 'session_expired');
        }
        $_SESSION['last_activity'] = time();
        return $_SESSION['user'];
    }

    public static function updateUser(array $user): void
    {
        self::start();
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function remember(string $username): void
    {
        setcookie(self::REMEMBER_COOKIE, $username, ['expires' => time() + 2592000, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }

    public static function forgetRememberedUsername(): void
    {
        setcookie(self::REMEMBER_COOKIE, '', ['expires' => time() - 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }

    public static function redirect(string $route, ?string $type = null, ?string $message = null): never
    {
        $query = ['route' => $route];
        if ($type !== null && $message !== null) {
            $query[$type] = $message;
        }
        header('Location: ' . self::baseUrl() . '/index.php?' . http_build_query($query));
        exit;
    }

    public static function baseUrl(): string
    {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/WorkShop4/index.php');
        return rtrim(dirname($script), '/');
    }
}
