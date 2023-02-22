<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Inertia\Inertia;

class DiscoverController extends Controller
{
    public function index()
    {
        $discoverChannels = auth()->check()
            ? auth()->user()->unjoinedChannels
            : Channel::all();

        $channels = auth()->check()
            ? auth()->user()->channels
            : collect();

        return Inertia::render('Discover/Index', [
            'authed' => auth()->check(),
            'channels' => $channels->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                    'relayurl' => $channel->relayurl,
                    'eventid' => $channel->eventid,
                ];
            }),
            'discoverChannels' => $discoverChannels->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                    'relayurl' => $channel->relayurl,
                    'eventid' => $channel->eventid,
                ];
            }),
        ]);
    }
}
