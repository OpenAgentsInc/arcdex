<?php

use App\Models\User;

test('user can create a channel', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels', [
        'title' => 'Test Channel',
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
});
