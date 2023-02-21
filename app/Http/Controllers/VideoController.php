<?php

namespace App\Http\Controllers;

class VideoController extends Controller
{
    public function show($id)
    {
        $videos = [
            [
                'id' => 1,
                'title' => 'Introduction',
                'subtitle' => 'We are building a Nostr chat app.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc1.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 2,
                'title' => 'Project Setup',
                'subtitle' => 'We install Laravel and write our first API endpoint via TDD.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc2.mov',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Deploy via Forge',
                'subtitle' => 'We build this landing page and deploy via Laravel Forge.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc3.mov',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 4,
                'title' => 'React+Tailwind Chat UI',
                'subtitle' => 'We build a web chat UI via React and Tailwind.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc4.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 5,
                'title' => 'Video Player',
                'subtitle' => 'We build a video player to show our content here.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc5.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 6,
                'title' => 'Nostr Channel Membership',
                'subtitle' => 'We discuss channel membership and write API endpoints for joining, retrieving, and leaving Nostr channels.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc6.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 7,
                'title' => 'Nostr Connect',
                'subtitle' => "We integrate Nostr Connect (NIP-46) to get the user's public key from a signer app.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc7.mov',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 8,
                'title' => 'API Authentication',
                'subtitle' => "We authenticate the Nostr Connect user with our API using Laravel Sanctum.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc8.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 9,
                'title' => 'Installing Inertia',
                'subtitle' => "We'll use Inertia to connect our Laravel backend with our React frontend.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc9.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 10,
                'title' => 'Creating Channels, Part 1',
                'subtitle' => "We allow authenticated users to create chat channels in our database.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc10.mp4',
                'user' => [
                    'id' => 1,
                    'name' => 'Christopher David'
                ]
            ],
            [
                'id' => 11,
                'title' => 'Creating Channels, Part 2',
                'subtitle' => "We send the NIP-28 channel creation event to a Nostr relay.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc11.mp4',
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
