<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ChannelController extends Controller
{
    public function store() {
        $data = request()->validate([
            'title' => 'required',
        ]);

        Auth::user()->channels()->create($data);

        return Redirect::route('chat')->with('success', 'Channel created.');
    }
}
