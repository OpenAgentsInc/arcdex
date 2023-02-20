<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        return Inertia::render('Chat/ChatHome', [
            'channels' => $user->channels->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                ];
            }),
        ]);
    }
}
