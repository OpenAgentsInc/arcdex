<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChannelMessageController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/nonce', [LoginController::class, 'nonce']);
Route::post('/login', [LoginController::class, 'apiLogin']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/channels', [ChannelController::class, 'index']);
    Route::post('/channels', [ChannelController::class, 'store']);
    Route::post('/channels/{channel}/join', [ChannelController::class, 'join']);
    Route::delete('/channels/{channel}/join', [ChannelController::class, 'leave']);
    Route::post('/channels/{channel}/messages', [ChannelMessageController::class, 'store']);
});
