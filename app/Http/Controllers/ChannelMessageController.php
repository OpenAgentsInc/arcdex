<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelMessageController extends Controller
{
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
