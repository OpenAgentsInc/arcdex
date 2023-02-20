<?php

namespace App\Http\Controllers;

use App\Jobs\CreateNostrChannel;
use App\Models\Channel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class ChannelController extends Controller
{
    public function store()
    {
        // Create a channel in our database
        $channel = Channel::create(Request::validate([
            'title' => ['required', 'max:50'],
        ]));

        // User who created the channel is automatically added to the channel
        $channel->users()->attach(auth()->user());

        // Create the channel on Nostr
        CreateNostrChannel::dispatch($channel);

        // Redirect back to the chat page
        return Redirect::route('chat')->with('success', 'Channel created.');
    }
}
