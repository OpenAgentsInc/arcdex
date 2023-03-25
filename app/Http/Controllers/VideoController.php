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
            ],
            [
                'id' => 27,
                'title' => 'Exploring the ChatGPT API',
                'subtitle' => 'We explore the ChatGPT API and build a simple chatbot.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc27_9f8860f01cd33bde7fc507d2372d4f02.mp4'
            ],
            [
                'id' => 28,
                'title' => 'App Refactor Planning',
                'subtitle' => "We plan the major refactor for v0.0.4, in which we'll convert the app to use our new chat API and indexer.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc28_150c124d73ce86f2321faf5c0f6775e2.mp4'
            ],
            [
                'id' => 29,
                'title' => 'Deleting & Upgrading',
                'subtitle' => "We delete a lot of app code we won't need in v0.0.4, then upgrade to Expo 48.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc29_89a806cc1efcfd539681a7cc325b1eef.mp4'
            ],
            [
                'id' => 30,
                'title' => 'API Handshake via TanStack Query',
                'subtitle' => "We connect the app to our new API via TanStack Query, showing a list of demo channels the user has joined.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc30_1a1cfb0d81da5744ab7c31b42c6e1f79.mp4'
            ],
            [
                'id' => 31,
                'title' => 'Securing the API',
                'subtitle' => "We securely authenticate a Nostr keypair with our new Laravel API. Enjoy 5+ hours of wrestling with nonces, x-only pubkeys, and PHP elliptic curve cryptography libraries.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc31_ac7e24af993ebc8648839b04009da3ba.mov'
            ],
            [
                'id' => 32,
                'title' => 'In-App Video Player',
                'subtitle' => "We add a video player to the app and mock up how we could integrate Nostr chat and Lightning zaps.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc32_ceded7c0aeeb193605e156804db0ae6b.mp4'
            ],
            [
                'id' => 33,
                'title' => 'Saving & Rehydrating the API Token',
                'subtitle' => "Our most boring video yet. We save the API token to the device keychain, then rehydrate it on app launch.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc33_678962ac821ed0d888b041e78ac83f87.mp4'
            ],
            [
                'id' => 34,
                'title' => 'Listing Joined & Unjoined Channels',
                'subtitle' => "We connect the app to our new channels API endpoint, showing lists of channels the user has joined and not.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc34_3d5aa4cfbb84720af2515e47fdb06374.mp4'
            ],
            [
                'id' => 35,
                'title' => 'Joining, Leaving & Creating Channels',
                'subtitle' => "We connect the app to more API endpoints, allowing the user to join, leave, and create channels.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc35_9507b5eea06ae218c49859544c2da0ca.mp4'
            ],
            [
                'id' => 36,
                'title' => 'Sending & Retrieving Messages',
                'subtitle' => "We connect a few more API endpoints and can now send and retrieve NIP-28 chat messages in the mobile app.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc36_160b45023ea26c5be2018b6626b4c6eb.mp4'
            ],
            [
                'id' => 37,
                'title' => 'Hello Nostr',
                'subtitle' => "We connect the app to our production database and say hello in a few pre-existing Nostr channels.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc37_e98446e7a386fd1c8ecb6e95fee1c355.mp4'
            ],
            [
                'id' => 38,
                'title' => 'Indexer Planning',
                'subtitle' => "We discuss our need for an event indexer and plan to build a new one using Rust.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc38-1080_4fa01f99e678078ef0a98cff9ebd9794.mov'
            ],
            [
                'id' => 39,
                'title' => 'Indexer Connects to Relays',
                'subtitle' => "Our new Rust indexer successfully connects to relays and subscribes to events.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc39-1080_03d40c3e97fd3f237fdb5e47430d011d.mov'
            ],
            [
                'id' => 40,
                'title' => 'Indexer Saves Events to Database',
                'subtitle' => "Our new indexer saves 1000+ Nostr events to a PlanetScale MySQL database.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/arc40.mov'
            ],
            [
                'id' => 41,
                'title' => 'Indexer UI & Finding Relays',
                'subtitle' => "The indexer UI now shows the number of indexed events, updating every second. And we use NIP-65 to build a list of 200+ relays we'll index next.",
                "url" => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc41rush_20be598e89880f431597a427acb6ccd5.mp4'
            ],
            [
                'id' => 42,
                'title' => 'Indexing 150K+ Chat Messages',
                'subtitle' => 'We loop through our list of ~200 relays and index 150,000+ NIP-28 chat messages.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc42rush_563eef1248abd4a758a4e7de18eef8ca.mp4'
            ],
            [
                'id' => 43,
                'title' => 'Indexer Lists Connected Relays',
                'subtitle' => "We list all connected relays on the indexer UI, updating instantly when connection status changes.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc43_f76f7f592a3e52245de5b3a2df98d29c.mp4'
            ],
            [
                'id' => 44,
                'title' => 'Rewrite It In Rust?',
                'subtitle' => 'We explore the indexed messages and brainstorm rewriting our API in Rust.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc44_e36328dc32a831f023c8cdce41998377.mp4'
            ],
            [
                'id' => 45,
                'title' => 'Finalizing v0.0.4',
                'subtitle' => 'We finalize phase one of our API refactor and build v0.0.4 for Android & iOS release.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc45_54db16377a5f913203d770035535973d.mp4'
            ],
            [
                'id' => 46,
                'title' => 'Hello Nostr Development Kit',
                'subtitle' => 'We explore the new Nostr Development Kit (NDK) and complete its Hello World tutorial in a fresh Tauri app.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc46_2d3b1da1f07d9d683f1e55846c458645.mp4'
            ],
            [
                'id' => 47,
                'title' => 'Chat Zaps, Part 1',
                'subtitle' => "We explore the NIP-57 Lightning Zaps spec and extend our Rust app to create an LNURL pay request from a user's Nostr profile.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc47_561fecb439f422ec6331e63b983cd058.mp4'
            ],
            [
                'id' => 48,
                'title' => 'Chat Zaps, Part 2',
                'subtitle' => "We explore the Damus codebase and rewrite their Zap test in Rust.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc48_d464244bf7237413d76e5f95fd7313c8.mp4'
            ],
            [
                'id' => 49,
                'title' => 'Going Universal',
                'subtitle' => 'We begin converting the main Arc codebase into a cross-platform app (web, mobile & desktop) via create-universal-app.',
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc49_69a31c2a9687a1b648af9b88567852cd.mp4'
            ],
            [
                'id' => 50,
                'title' => 'Starting a Design System',
                'subtitle' => "We learn about design systems and component-driven development, then start a design showcase where we'll review individual Arc components.",
                'url' => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc50_1030de31e3e6e103a63170c9c9d4be32.mp4'
            ],
            [
                'id' => 51,
                'title' => 'Exploring GPT-4',
                'subtitle' => "We explore the new GPT-4 and evaluate its ability to help with Arc development.",
                "url" => "https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc51_55384600085c30b4ac3854777e87723e.mp4"
            ],
            [
                'id' => 52,
                'title' => 'Identifying Fake Nostr Accounts',
                'subtitle' => 'We submit an OpenAI eval to help GPT-4 identify Nostr spambots, and hopefully earn early access to the GPT-4 API.',
                "url" => "https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc52_6488d9b1fd9601988bcd394979216880.mp4"
            ],
            [
                'id' => 53,
                'title' => 'Exploring the Signal SDK',
                'subtitle' => "We review the draft NIPs for encrypted group chat and explore a potential integration of the Signal SDK.",
                "url" => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc53_b2f551d8936247bea3fdbdbebbddb291.mp4'
            ],
            [
                'id' => 54,
                'title' => 'Chat Zaps, Part 3',
                'subtitle' => "We integrate the NIP-57 Lightning Zaps spec into the Arc mobile app and send our first zaps to a few random Nostr users.",
                "url" => 'https://d22hdgrsmzgwgk.cloudfront.net/uploads/arc54_5ece62b11c3df8c13d713847703cfa6b.mp4'
            ]
        ];
    }
}
