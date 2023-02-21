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

    public function fetchRecentChannels()
    {
        $subscriptionId = bin2hex(random_bytes(16));

        $filters = [
            "kinds" => [40],
            "limit" => 20
        ];

        $requestMessage = ["REQ", $subscriptionId, $filters];

        $this->client->send(json_encode($requestMessage));

        $events = [];

        while (count($events) < 20) {
            $responseMessage = json_decode($this->client->receive(), true);

            if ($responseMessage[0] === "EVENT" && $responseMessage[1] === $subscriptionId) {
                $event = $responseMessage[2];
                $events[] = $event;
            } elseif ($responseMessage[0] === "CLOSE" && $responseMessage[1] === $subscriptionId) {
                break;
            }
        }

        return $events;
    }

    public function checkRelayForEvent($eventId = "c32251a74d641f0fdae5cd00fd0148fe82397db6b87d534431c248d268020f3d")
    {
        $subscriptionId = bin2hex(random_bytes(16));

        $filters = [
            "ids" => [$eventId],
            "limit" => 1
        ];

        $requestMessage = ["REQ", $subscriptionId, $filters];

        $this->client->send(json_encode($requestMessage));

        $responseMessage = json_decode($this->client->receive(), true);

        if ($responseMessage[0] === "EVENT" && $responseMessage[1] === $subscriptionId) {
            $event = $responseMessage[2];
            return $event;
        } else {
            return null;
        }
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
