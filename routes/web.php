<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DependencyUploadController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\LanderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

Route::get('/', [LanderController::class, 'index'])->name('home');
Route::get('/beta', [LanderController::class, 'beta'])->name('beta');
Route::get('/videos', [VideoController::class, 'index'])->name('videos');

// Define a route only if we are in the local app_env
if (app()->environment('local')) {
    Route::get('/pv', function () {
        return view('pv');
    })->name('pv');

    Route::post('upload', [DependencyUploadController::class, 'uploadFile']);
}

Route::get('/lofi', [AudioController::class, 'lofi'])->name('lofi');

Route::get('/discover', [DiscoverController::class, 'index'])->name('discover');

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/channel/{channel}', [ChannelController::class, 'show'])->name('channel');
});

Route::get('/video/{id}', [VideoController::class, 'show']);

Route::any('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');


Route::post('/sanctum/token', [LoginController::class, 'apiLoginOld']);


Route::post('/login', function (Request $request) {
    // if user is already logged in, log them out
    if (Auth::check()) {
        Auth::logout();
    }

    $validator = Validator::make($request->all(), [
        'pubkey' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    $pubkey = $request->input('pubkey');
    // find the user with this pubkey
    $user = User::where('pubkey', $pubkey)->first();
    // if no user, return error
    if (!$user) {
        // Create a user with this pubkey and log them in
        $user = User::create([
            'pubkey' => $pubkey
        ]);
    }

    // otherwise log in the user
    Auth::login($user);

    return response()->json([
        'message' => 'success'
    ], 200);
});
