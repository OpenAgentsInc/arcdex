<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Inertia\Inertia;

class DiscoverController extends Controller
{
    public function index()
    {
        $channels = auth()->check()
            ? auth()->user()->unjoinedChannels
            : Channel::all();

        return Inertia::render('Discover/Index', [
            'channels' => [],
            'discoverChannels' => $channels->map(function ($channel) {
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
