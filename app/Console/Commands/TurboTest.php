<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI;

class TurboTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turbo:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test turbo ChatGPT shaz';

    public function handle()
    {
        $this->info('Reading TurboTest file contents...');
        $path = app_path('Console/Commands/TurboTest.php');
        $contents = file_get_contents($path);
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Analyze this code: \n```\n " . $contents . "\n```\n\n",
                ],
            ],
        ]);

        $message = $response->toArray()['choices'][0]['message']['content'];

        $this->info($message);
    }
}
