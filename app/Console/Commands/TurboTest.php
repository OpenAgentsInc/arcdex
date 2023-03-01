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

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $this->info('Testing gpt turbo...');

    //     $client = OpenAI::client(env('OPENAI_API_KEY'));

    //     $response = $client->chat()->create([
    //         'model' => 'gpt-3.5-turbo',
    //         'messages' => [
    //             ['role' => 'user', 'content' => 'What is Nostr'],
    //         ],
    //     ]);

    //     $response->id; // 'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq'
    //     $response->object; // 'chat.completion'
    //     $response->created; // 1677701073
    //     $response->model; // 'gpt-3.5-turbo-0301'

    //     foreach ($response->choices as $result) {
    //         $result->index; // 0
    //         $result->message->role; // 'assistant'
    //         $result->message->content; // '\n\nHello there! How can I assist you today?'
    //         $result->finishReason; // 'stop'
    //     }

    //     $response->usage->promptTokens; // 9,
    //     $response->usage->completionTokens; // 12,
    //     $response->usage->totalTokens; // 21

    //     $response->toArray(); // ['id' => 'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq', ...]
    //     // print_r($response->toArray()) ;

    //     $message = $response->toArray()['choices'][0]['message']['content'];

    //     $this->info($message);
    // }
}
