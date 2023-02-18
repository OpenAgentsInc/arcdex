<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($id)
    {
        $videos = [
            [
                'id' => 1,
                'title' => 'Introduction',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc1.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 2,
                'title' => 'Project Setup',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc2.mov',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Deploy via Forge',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc3.mov',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 4,
                'title' => 'React+Tailwind Chat UI',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc4.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
        ];

        try {
            $video = $videos[(int) $id - 1];
            return view('video', [
                'video' => $video,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
}
