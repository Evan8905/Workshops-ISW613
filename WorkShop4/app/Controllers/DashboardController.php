<?php

namespace App\Controllers;

use App\Services\Session;
use App\Services\View;

final class DashboardController
{
    public function index(): void
    {
        View::render('dashboard/index', ['user' => Session::requireUser()]);
    }
}
