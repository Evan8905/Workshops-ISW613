<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Session;
use App\Services\View;

final class UserController
{
    public function index(): void
    {
        Session::requireUser();
        View::render('users/index', ['users' => User::all()]);
    }
}
