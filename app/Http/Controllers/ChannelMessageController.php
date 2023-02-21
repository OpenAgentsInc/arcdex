<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChannelMessageController extends Controller
{
    public function store (Request $request, Channel $channel) {
        $channel->messages()->create([
            'user_id' => auth()->user()->id,
            'content' => $request->content,
            'eventid' => $request->eventid,
            'relayurl' => $request->relayurl,
        ]);

        return Redirect::to('channel/' . $channel->id)->with('success', 'Message sent.');
    }
}
