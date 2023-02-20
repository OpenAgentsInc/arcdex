<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VideoController;
use App\Models\Channel;
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

Route::get('/chat', [ChatController::class, 'index'])->middleware('auth')->name('chat');

// Route::get('/chat', function () {
//     return view('chat');
// });

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {

    // if user is already logged in, dd with error message
    if (Auth::check()) {
        dd('User already logged in');
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

        // return response()->json([
        //     'message' => 'error',
        //     'errors' => [
        //         'user' => 'User not found'
        //     ]
        // ], 404);
    }

    // otherwise log in the user
    Auth::login($user);

    return response()->json([
        'message' => 'success'
    ], 200);
});

Route::middleware('auth:sanctum')->post('/api/channels', [ChannelController::class, 'store']);

Route::middleware('auth:sanctum')->get('/api/channels', function (Request $request) {
    // Check for joined query param
    if ($request->query('joined') === 'false') {
        // Retrieve only channels that the user has not joined, and eager load the last message
        $channels = Channel::whereDoesntHave('users', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->with(['messages' => function($q) {
            $q->latest();
        }])->get();
    } else {
        // Retrieve only channels that the user has joined, and eager load the last message
        $channels = $request->user()->channels()->with(['messages' => function($q) {
            $q->latest();
        }])->get();
    }

    foreach ($channels as $channel) {
        try {
            $channel['lastMessage'] = $channel->messages->first()->load('user');
        } catch (Throwable $e) {
            $channel['lastMessage'] = null;
        }
    }

    return [
        'data' => $channels
    ];
});
