<?php

use App\Jobs\CreateNostrChannel;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

test('user can create a channel', function () {
    Queue::fake();
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels', [
        'title' => 'Test Channel',
        'eventid' => 'test-event-id',
        'about' => 'test about',
        'relayurl' => 'https://test-relay-url.com'
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect('/chat/')
        ->assertSessionHas('success', 'Channel created.');

    // assert that the channel was created
    $this->assertDatabaseHas('channels', [
        'id' => 1,
        'title' => 'Test Channel',
    ]);

    // assert that the user is a member of the channel
    $this->assertDatabaseHas('channel_user', [
        'user_id' => $user->id,
        'channel_id' => 1,
    ]);

    // assert that the user belongs to the channel
    expect($user->channels->first()->id)->toBe(1);

    // asser that a CreateNostrChannel job was NOT pushed - maybe do this later
    Queue::assertNotPushed(CreateNostrChannel::class, function ($job) {
        return $job->channel->id === 1;
    });
});
