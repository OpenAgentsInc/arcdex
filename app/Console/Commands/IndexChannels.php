<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Services\WebSocketClientService;
use Illuminate\Console\Command;
use Throwable;

class IndexChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes channels';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing channels...');

        $relays = ["wss://relay.damus.io", "wss://nostr.mom", "wss://relay.current.fyi", "wss://nostr.developer.li", "wss://knostr.neutrine.com"];

        // loop through each relay
        for ($i = 0; $i < count($relays); $i++) {
            $relayUrl = $relays[$i];
            $this->indexChannels($relayUrl);
        }
    }

    protected function indexChannels($relayUrl) {
        $this->info("Indexing channels from {$relayUrl}...");
        $svc = new WebSocketClientService($relayUrl);
        try {
            $channelData = $svc->fetchRecentChannels();
        } catch (\WebSocket\TimeoutException $e) {
            $this->error("Timeout connecting to relay: {$relayUrl}");
            return;
        } catch (\WebSocket\ConnectionException $e) {
            $this->error("Connection error connecting to relay: {$relayUrl}");
            return;
        } catch (Throwable $e) {
            $this->error("Unknown error connecting to relay: {$relayUrl}");
            return;
        }

        $channels = [];
        foreach ($channelData as $data) {
            $content = json_decode($data['content'], true);
            try {
                $channel = Channel::create([
                    'title' => $content['name'] ?? '',
                    'about' => $content['about'] ?? '',
                    'picture' => $content['picture'] ?? '',
                    'relayurl' => $relayUrl,
                    'eventid' => $data['id'],
                ]);
                // dd($channel);
                array_push($channels, $channel);
                $this->info("Indexed channel: {$content['name']}");
            } catch (\Illuminate\Database\QueryException $e) {
                // dd($e->getMessage());
                // $this->warn("Channel already exists: {$content['name']}");
            }
        }

        $this->info("Indexed " . count($channels) . " channels from {$relayUrl}.");
        return $channels;
    }
}
