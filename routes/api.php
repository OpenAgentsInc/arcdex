<?php

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/channels', function (Request $request) {
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

Route::middleware('auth:sanctum')->post('/channels/{channel}/join', function (Request $request, Channel $channel) {
    $channel->users()->syncWithoutDetaching($request->user()->id);

    return [
        'data' => [
            'id' => $channel->id,
            'title' => $channel->title,
            'joined' => true,
        ]
    ];
});

Route::middleware('auth:sanctum')->delete('/channels/{channel}/join', function (Request $request, Channel $channel) {
    $channel->users()->detach($request->user()->id);

    return [
        'data' => [
            'id' => $channel->id,
            'title' => $channel->title,
            'joined' => false,
        ]
    ];
});

Route::middleware('auth:sanctum')->get('/messages', function (Request $request) {
    $messages = Message::with('user')->get();
    return [
        'data' => $messages
    ];
});
