<?php

namespace App\Http\Controllers;

use App\Models\Channel;
// use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class ChannelController extends Controller
{
    public function store(Request $request)
    {
        // $title = Request::input('title');
        // $what = Request::validate([
        //     'title' => ['required', 'max:50'],
        // ]);

        $channel = Channel::create(Request::validate([
            'title' => ['required', 'max:50'],
        ]));
        // dd($channel);
        // $request->validate([
        //     // 'title' => ['required', 'max:50'],
        // ])
        // dd($channel);

        $channel->users()->attach(auth()->user());

        return Redirect::route('chat')->with('success', 'Channel created.');
    }
}
