<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LanderController extends Controller
{
    public function index()
    {
        $videos = VideoController::grabVideos();
        $mostRecentVideo = $videos[count($videos) - 1];
        return Inertia::render('Lander/Home', [
            'video' => $mostRecentVideo,
        ]);
    }

    public function beta()
    {
        return Inertia::render('Lander/Beta');
    }
}
