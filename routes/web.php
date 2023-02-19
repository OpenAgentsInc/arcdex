<?php

use App\Http\Controllers\VideoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/channel/building-arc', function () {
//     return view('channel');
// });

Route::get('/video/{id}', [VideoController::class, 'show']);

Route::get('/chat', function () {
    return view('chat');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
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
        return response()->json([
            'message' => 'error',
            'errors' => [
                'user' => 'User not found'
            ]
        ], 404);
    }

    // otherwise log in the user
    Auth::login($user);

    return response()->json([
        'message' => 'success'
    ], 200);
});
