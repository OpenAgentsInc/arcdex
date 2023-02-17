<?php

use App\Models\Message;
use App\Models\User;

it('belongs to a user', function () {
    $message = Message::factory()->create();

    $this->assertInstanceOf(User::class, $message->user);
});

it('has message content', function () {
    $message = Message::factory()->create();

    $this->assertIsString($message->text);
});
