<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/ChatHome', [
            'channels' => auth()->user()->channels->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                ];
            }),
        ]);
    }
}
