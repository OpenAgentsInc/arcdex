<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function store()
    {
        $validation = Request::validate([
            'title' => ['required', 'max:50'],
            'eventid' => ['required'],
            'relayurl' => ['required'],
        ]);

        // Create a channel in our database
        $channel = Channel::create($validation);
        // dd($channel);

        // User who created the channel is automatically added to the channel
        $channel->users()->attach(auth()->user());

        // Create the channel on Nostr (skipping for now - doing it client-side - may revisit later)
        // CreateNostrChannel::dispatch($channel);

        // Redirect back to the chat page
        return Redirect::route('chat')->with('success', 'Channel created.');
    }

    public function show($id) {
        $channel = Channel::find($id);
        return Inertia::render('Chat/Channel', [
            'channel' => $channel->only('id', 'title', 'relayurl', 'eventid'),
            'channels' => auth()->user()->channels->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                ];
            }),
            'messages' => $channel->messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    // 'user' => $message->user->only('id', 'name'),
                    'content' => $message->content,
                    'eventid' => $message->eventid,
                    'relayurl' => $message->relayurl,
                    'created_at' => $message->created_at->diffForHumans(),
                ];
            }),
        ]);
    }
}
