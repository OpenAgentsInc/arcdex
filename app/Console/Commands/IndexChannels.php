<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Services\WebSocketClientService;
use Illuminate\Console\Command;

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
        $svc = new WebSocketClientService('wss://nostr.vulpem.com');
        // dd($svc);
        $channelData = $svc->fetchRecentChannels();
    //    dd($channelData);
        // $this->info(json_encode($channels));

        // $channelData = json_decode($payload, true);

        $channels = [];
        foreach ($channelData as $data) {
            $content = json_decode($data['content'], true);
            $channel = Channel::create([
                // 'id' => $data['id'],
                'title' => $content['name'] ?? '',
                'relayurl' =>  'wss://nostr.vulpem.com',
                'eventid' => $data['id'],
                // 'picture' => $content['picture'] ?? '',
                // 'description' => $content['about'] ?? '',
                // 'createdAt' => $data['created_at'],
            ]);
            array_push($channels, $channel);
        }



        // foreach ($channels as $channel) {
        //     $model = new Channel([
        //         'title' => $channel['title'],
        //         'eventid' => $channel['eventid'],
        //         'relayurl' => $channel['relayurl'],
        //     ]);
        //     // $model->user()->associate(User::first()); // replace with actual user
        //     $model->save();
        // }

        $this->info(count($channels) . ' channels indexed!');
        return $channels;

        // $this->info(json_encode($channels));
        // $this->info('Channels indexed!');
    }
}
