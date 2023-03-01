<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class VideoController extends Controller
{
    private $videos;

    function __construct()
    {
        $this->videos = $this->getVideos();
    }

    public function index()
    {
        return Inertia::render('Videos/Index', [
            'videos' => $this->videos,
        ]);
    }

    public function show($id)
    {
        try {
            $video = $this->videos[(int) $id - 1];
            return view('video', [
                'video' => $video,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    public static function grabVideos()
    {
        $videos = (new self)->getVideos();
        return $videos;
    }

    public function getVideos()
    {
        return [
            [
                'id' => 1,
                'title' => 'Introduction',
                'subtitle' => 'We are building a Nostr chat app.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc1.mp4',
            ],
            [
                'id' => 2,
                'title' => 'Project Setup',
                'subtitle' => 'We install Laravel and write our first API endpoint via TDD.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc2.mov',
            ],
            [
                'id' => 3,
                'title' => 'Deploy via Forge',
                'subtitle' => 'We build this landing page and deploy via Laravel Forge.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc3.mov',
            ],
            [
                'id' => 4,
                'title' => 'React+Tailwind Chat UI',
                'subtitle' => 'We build a web chat UI via React and Tailwind.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc4.mp4',
            ],
            [
                'id' => 5,
                'title' => 'Video Player',
                'subtitle' => 'We build a video player to show our content here.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc5.mp4',
            ],
            [
                'id' => 6,
                'title' => 'Nostr Channel Membership',
                'subtitle' => 'We discuss channel membership and write API endpoints for joining, retrieving, and leaving Nostr channels.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc6.mp4',
            ],
            [
                'id' => 7,
                'title' => 'Nostr Connect',
                'subtitle' => "We integrate Nostr Connect (NIP-46) to get the user's public key from a signer app.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc7.mov',
            ],
            [
                'id' => 8,
                'title' => 'API Authentication',
                'subtitle' => "We authenticate the Nostr Connect user with our API using Laravel Sanctum.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc8.mp4',
            ],
            [
                'id' => 9,
                'title' => 'Installing Inertia',
                'subtitle' => "We'll use Inertia to connect our Laravel backend with our React frontend.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc9.mp4',
            ],
            [
                'id' => 10,
                'title' => 'Creating Channels, Part 1',
                'subtitle' => "We allow authenticated users to create chat channels in our database.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc10.mp4',
            ],
            [
                'id' => 11,
                'title' => 'Creating Channels, Part 2',
                'subtitle' => "We send the NIP-28 channel creation event to a Nostr relay.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc11.mp4',
            ],
            [
                'id' => 12,
                'title' => 'UI Cleanup',
                'subtitle' => "We clean up the chat UI.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc12.mp4',
            ],
            [
                'id' => 13,
                'title' => 'Sending Messages',
                'subtitle' => "We send our first message to a Nostr channel we created.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc13.mp4',
            ],
            [
                'id' => 14,
                'title' => 'Indexing Channels, Part 1',
                'subtitle' => "We write an event indexer and save 20 Nostr channels to our database.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc14.mp4',
            ],
            [
                'id' => 15,
                'title' => 'Indexing Channels, Part 2',
                'subtitle' => "We connect to more relays and index 300+ channels.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc15.mp4',
            ],
            [
                'id' => 16,
                'title' => 'Discovering Channels',
                'subtitle' => "We build a Discover page listing all indexed channels and allowing users to join any channel.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc16.mp4',
            ],
            [
                'id' => 17,
                'title' => 'Retrieving Messages',
                'subtitle' => "We retrieve channel messages from relays so we can see the messages we sent.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc17.mp4',
            ],
            [
                'id' => 18,
                'title' => 'Delegated Event Signing (NIP-26)',
                'subtitle' => "We integrate NIP-26 via Nostr Connect. Enjoy this unedited 4+ hours of agony and noob mistakes, followed by a glorious world-first.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc18.mov',
            ],
            [
                'id' => 19,
                'title' => 'Adding Radix UI',
                'subtitle' => "We rebuild our login page using Radix UI components, refactoring as we go.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc19.mp4',
            ],
            [
                'id' => 20,
                'title' => 'Refactoring Login & Delegation',
                'subtitle' => "We do some boring refactoring, then complete our NIP-26 integration by reusing delegations and showing the correct user pubkey on messages.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc20.mp4',
            ],
            [
                'id' => 21,
                'title' => 'Remote Signing via Arc Mobile',
                'subtitle' => "We move NIP-26 signing code from the demo app Nostrum into the Arc mobile app, enabling our mobile Arc user to sign messages on the web app.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc21.mp4',
            ],
            [
                'id' => 22,
                'title' => 'New Landing Page',
                'subtitle' => "We build a proper landing page for the Arc website.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc22.mp4',
            ],
            [
                'id' => 23,
                'title' => 'Lofi Audio Player',
                'subtitle' => "We build an audio player to listen to Lofi Girl music while we code.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc23.mp4',
            ],
            [
                'id' => 24,
                'title' => 'Restyling & Building v0.0.3',
                'subtitle' => "We restyle Nostrum components with Tamagui, then build the beta v0.0.3 app for release.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc24.mp4',
            ],
            [
                'id' => 25,
                'title' => 'Releasing v0.0.3',
                'subtitle' => "We finalize the Android build and make a beta webpage with v0.0.3 download links.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc25.mp4',
            ],
            [
                'id' => 26,
                'title' => 'Video Uploader',
                'subtitle' => 'We build a video uploader while learning about programmatic access to Amazon S3 via Laravel.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc26_60d663dc81776864aed02bbc0be0bfda.mp4'
            ]
        ];
    }
}
