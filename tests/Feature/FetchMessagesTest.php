<?php

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;

test('user can retrieve messages for a channel they are in', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();
    $channel->users()->attach($user->id);

    $message = Message::factory()->create([
        'channel_id' => $channel->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    $response = $this->get('/api/channels/' . $channel->id . '/messages');

    $response->assertStatus(200)
        ->assertJson([
            'messages' => [
                [
                    'id' => $message->id,
                    'content' => $message->content,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ],
                ],
            ],
        ]);
});
