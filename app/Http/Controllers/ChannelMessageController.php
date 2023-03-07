<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelMessageController extends Controller
{
    public function index(Channel $channel) {
        $messages = $channel->messages()->with('user')->get();
        $filtered = $messages->map(function ($message) {
           return [
                'id' => $message->id,
                'content' => $message->content,
                'pubkey' => $message->user->pubkey,
                'created_at' => $message->created_at,
           ];
        });
        return [
            'messages' => $filtered,
        ];
    }

    public function store (Request $request, Channel $channel) {
        $channel->messages()->create([
            'user_id' => auth()->user()->id,
            'content' => $request->text,
            'eventid' => $request->eventid,
            'relayurl' => $request->relayurl,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
        ], 200);
    }
}
