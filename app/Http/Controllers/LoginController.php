<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    // render login page via inertia
    public function index()
    {
        return Inertia::render('Login');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'pubkey' => 'required',
            'device_name' => 'required',
        ]);

        $pubkey = $request->pubkey;
        $user = User::where('pubkey', $pubkey)->first();
        if (!$user) {
            // Create a user with this pubkey and log them in
            $user = User::create([
                'pubkey' => $pubkey
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
