<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LanderController extends Controller
{
    public function index()
    {
        return Inertia::render('Lander/Home');
    }

    public function beta()
    {
        return Inertia::render('Lander/Beta');
    }
}
