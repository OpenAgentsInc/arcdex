<?php

use App\Http\Controllers\VideoController;
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

    return response()->json([
        'message' => 'success'
    ], 200);
});
