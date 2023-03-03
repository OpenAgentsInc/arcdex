<?php

namespace App\Http\Controllers;

use App\Exceptions\ProofException;
use App\Models\Nonce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Elliptic\EC;

class LoginController extends Controller
{
    // render login page via inertia
    public function index()
    {
        return Inertia::render('Login');
    }

    public function nonce(Request $request)
    {
        try {
            $request->validate([
                'pubkey' => 'required',
                'device_name' => 'required',
            ]);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'missing' => 'Missing required fields',
            ]);
        }

        $nonce = bin2hex(random_bytes(32));

        Nonce::create([
            'nonce' => $nonce,
            'pubkey' => $request->pubkey,
            'device_name' => $request->device_name
        ]);

        return [
            'nonce' => $nonce
        ];
    }

    public function apiLogin(Request $request)
    {
        try {
            $request->validate([
                'device_name' => 'required',
                'hash' => 'required',
                'nonce' => 'required',
                'pubkey' => 'required',
                'secp_pubkey' => 'required',
                'signature' => 'required',
            ]);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'missing' => 'Missing required fields',
            ]);
        }

        $device_name = $request->input('device_name');
        $hash = $request->input('hash');
        $nonce = $request->input('nonce');
        $pubkey = $request->input('pubkey');
        $secp_pubkey = $request->input('secp_pubkey');
        $signature = $request->input('signature');


        // TODO: Verify this nonce matches the nonce and associated data in our db table
        $dbnonce = Nonce::where('nonce', $nonce)->first();
        if (!$dbnonce) {
            throw new ProofException();
        }

        // Validate the proof was generated by the private key associated with the pubkey
        try {
            $ec = new EC('secp256k1');
            $key = $ec->keyFromPublic($secp_pubkey, 'hex');
            $verified = ($key->verify($hash, $signature) == TRUE) ? "true" : "false";
            if ($verified == "false") {
                throw new ProofException();
            }
        } catch (\Exception $e) {
            Log::error($e);
            throw new ProofException();
        }

        $user = User::create([
            'pubkey' => $pubkey
        ]);
        $token = $user->createToken($device_name)->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function apiLoginOld(Request $request)
    {
        $request->validate([
            'pubkey' => 'required',
            'device_name' => 'required',
            'proof' => 'required',
        ]);

        // Validate the proof was generated by the private key associated with the pubkey
        // TODO

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
