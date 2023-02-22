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



// Route::middleware('auth:sanctum')->post('/channels/{channel}/join', function (Request $request, Channel $channel) {
//     $channel->users()->syncWithoutDetaching($request->user()->id);

//     return [
//         'data' => [
//             'id' => $channel->id,
//             'title' => $channel->title,
//             'joined' => true,
//         ]
//     ];
// });

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
