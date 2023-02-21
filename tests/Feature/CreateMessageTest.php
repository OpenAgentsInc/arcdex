<?php

use App\Models\Channel;
use App\Models\User;

test('user can send a message', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $this->post('/api/channel/1/messages', [
        'content' => 'Hello world',
        'eventid' => 'test-event-id',
        'relayurl' => 'https://test-relay-url.com'
    ])
        ->assertStatus(302)
        ->assertRedirect('/channel/1');

    // assert that the message was created
    $this->assertDatabaseHas('messages', [
        'id' => 1,
        'channel_id' => $channel->id,
        'content' => 'Hello world',
        'eventid' => 'test-event-id',
        'relayurl' => 'https://test-relay-url.com',
    ]);
});
