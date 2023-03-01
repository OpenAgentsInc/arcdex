<?php

namespace App\Console\Commands;

use App\Models\TurboConvo;
use App\Models\TurboMessage;
use Illuminate\Console\Command;
use OpenAI;

class TurboTest extends Command
{
    protected $convo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turbo:test {userText}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test turbo ChatGPT shaz';

    public function handle()
    {
        // Grab the most recent TurboConvo
        $convo = TurboConvo::latest()->first();
         // If it doesn't exist, create a new TurboConvo
        if (!$convo) {
            $convo = new TurboConvo();
            $convo->save();
        }

        $this->convo = $convo;

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $content = $this->argument('userText');
        $messages = $this->buildMessagesFromConvo();
        $messages[] = [
            'role' => 'user',
            'content' => $content,
        ];

        $user_turbo_message = new TurboMessage();
        $user_turbo_message->content = $content;
        $user_turbo_message->role = 'user';
        $user_turbo_message->turbo_convo_id = $this->convo->id;
        $user_turbo_message->save();

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        $bot_message = $response->toArray()['choices'][0]['message']['content'];

        $bot_turbo_message = new TurboMessage();
        $bot_turbo_message->content = $bot_message;
        $bot_turbo_message->role = 'assistant';
        $bot_turbo_message->turbo_convo_id = $convo->id;
        $bot_turbo_message->save();

        // $convo->push($message, 'bot');

        $this->info($bot_message);
    }

    public function buildMessagesFromConvo () {
        $messages = $this->convo->messages->map(function ($message) {
            return [
                'role' => $message['role'],
                'content' => $message['content'],
            ];
        })->toArray();

        $messages[] = [
            'role' => "system",
            'content' => "You are Faerie, a magical faerie here to help the user with whatever they want."
        ];


        foreach ($this->convo->messages as $message) {
            $messages[] = [
                'role' => $message['role'],
                'content' => $message['content'],
            ];
        }

        // $path = app_path('Console/Commands/TurboTest.php');
        // $contents = file_get_contents($path);

        // $messages[] = [
        //     'role' => 'user',
        //     'content' => "Analyze this code and suggest improvements. \n ``` \n" . $contents . "\n ```",
        // ];

        return $messages;
    }
}
