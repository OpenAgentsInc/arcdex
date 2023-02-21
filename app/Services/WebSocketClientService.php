<?php

namespace App\Services;

use WebSocket\Client as WebSocketClient;

class WebSocketClientService
{
    protected $client;

    public function __construct($uri)
    {
        $this->client = new WebSocketClient($uri);
    }

    public function sendMessage($message)
    {
        $this->client->text($message);
    }

    public function receiveMessage()
    {
        return $this->client->receive();
    }

    public function close()
    {
        $this->client->close();
    }
}
