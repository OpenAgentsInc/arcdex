<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;
use Throwable;

class ChannelController extends Controller
{
    public function store()
    {
        $validation = RequestFacade::validate([
            'title' => ['required', 'max:50'],
            'eventid' => ['required'],
            'about' => ['required'],
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
        // return Redirect::route('chat')->with('success', 'Channel created.');
        return [
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => true,
            ]
        ];
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

    // list all user is a member of
    public function index(Request $request)
    {
        $channels = auth()->user()->channels;

        if ($request->query('joined') === 'false') {
            // Retrieve only channels that the user has not joined, and eager load the last message
            $channels = Channel::whereDoesntHave('users', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })->with(['messages' => function($q) {
                $q->latest();
            }])->get();
        } else {
            // Retrieve only channels that the user has joined, and eager load the last message
            $channels = $request->user()->channels()->with(['messages' => function($q) {
                $q->latest();
            }])->get();
        }

        foreach ($channels as $channel) {
            try {
                $channel['lastMessage'] = $channel->messages->first()->load('user');
            } catch (Throwable $e) {
                $channel['lastMessage'] = null;
            }
        }

        return [
            'channels' => $channels
        ];
    }

    public function join(Channel $channel, Request $request)
    {
        $channel->users()->syncWithoutDetaching($request->user()->id);

        return [
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => true,
            ]
        ];
    }

    public function leave(Channel $channel, Request $request)
    {
        $channel->users()->detach($request->user()->id);

        return [
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => false,
            ]
        ];
    }
}
