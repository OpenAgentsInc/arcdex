<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LoginController extends Controller
{
    // render login page via inertia
    public function index()
    {
        return Inertia::render('Login');
    }
}
