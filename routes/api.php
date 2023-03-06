<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\LoginController;
use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/nonce', [LoginController::class, 'nonce']);
Route::post('/login', [LoginController::class, 'apiLogin']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/channels', [ChannelController::class, 'index']);
    Route::post('/channels', [ChannelController::class, 'store']);
    Route::delete('/channels/{channel}/join', [ChannelController::class, 'leave']);
});


// Route::middleware('auth:sanctum')->delete('/channels/{channel}/join', function (Request $request, Channel $channel) {
//     $channel->users()->detach($request->user()->id);

//     return [
//         'data' => [
//             'id' => $channel->id,
//             'title' => $channel->title,
//             'joined' => false,
//         ]
//     ];
// });

Route::middleware('auth:sanctum')->get('/messages', function (Request $request) {
    $messages = Message::with('user')->get();
    return [
        'messages' => $messages
    ];
});
