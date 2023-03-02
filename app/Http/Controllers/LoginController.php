<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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

        // $user = User::where('email', $request->email)->first();
        $pubkey = $request->pubkey;
        $user = User::where('pubkey', $pubkey)->first();
        // if no user, return error
        if (!$user) {
            // Create a user with this pubkey and log them in
            $user = User::create([
                'pubkey' => $pubkey
            ]);
        }
        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
