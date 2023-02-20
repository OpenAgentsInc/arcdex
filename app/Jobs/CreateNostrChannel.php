<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNostrChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;

    /**
     * Create a new job instance.
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Sending the channel creation event to relevant relays
    }
}
