<?php

namespace App\Controllers;

use App\Models\Province;
use App\Models\User;
use App\Services\Session;
use App\Services\View;
use PDOException;

final class AuthController
{
    public function showLogin(): void
    {
        View::render('auth/login', ['rememberedUsername' => $_COOKIE[Session::REMEMBER_COOKIE] ?? '']);
    }

    public function login(): void
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        if (!is_string($username) || !is_string($password) || trim($username) === '' || strlen($username) > 50 || $password === '') {
            Session::redirect('login', 'error', 'invalid_input');
        }
        try {
            $user = User::authenticate(trim($username));
        } catch (PDOException $exception) {
            error_log('Authentication database error: ' . $exception->getMessage());
            $user = false;
        }
        if ($user === false || !password_verify($password, $user['password_hash'])) {
            Session::redirect('login', 'error', 'invalid_credentials');
        }
        Session::login($user);
        isset($_POST['remember_me']) ? Session::remember($user['username']) : Session::forgetRememberedUsername();
        Session::redirect('dashboard');
    }

    public function showRegister(): void
    {
        View::render('auth/register', ['provinces' => Province::all()]);
    }

    public function register(): void
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmation = $_POST['confirm_password'] ?? null;
        $provinceId = $_POST['province_id'] ?? null;
        if (!is_string($username) || !is_string($password) || !is_string($confirmation) || trim($username) === '' || strlen(trim($username)) > 50 || !ctype_digit((string) $provinceId)) {
            Session::redirect('register', 'error', 'invalid_input');
        }
        if (strlen($password) < 8) Session::redirect('register', 'error', 'password_too_short');
        if ($password !== $confirmation) Session::redirect('register', 'error', 'password_mismatch');
        if (Province::find((int) $provinceId) === false) Session::redirect('register', 'error', 'invalid_province');
        try {
            User::create(trim($username), $password, (int) $provinceId);
        } catch (PDOException $exception) {
            Session::redirect('register', 'error', $exception->getCode() === '23000' ? 'username_taken' : 'server_error');
        }
        Session::redirect('login', 'success', 'registered');
    }

    public function logout(): void
    {
        Session::logout();
        Session::redirect('login', 'success', 'logged_out');
    }
}
