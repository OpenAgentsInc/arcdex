<?php

use App\Models\Channel;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('user can visit a channel page', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/channel/' . $channel->id);

    $response->assertStatus(200)
        // assert that this page has the channel info
        ->assertInertia(function (AssertableInertia $page) use ($channel) {
            $page->component('Chat/Channel')
                ->has('channel', function (AssertableInertia $page) use ($channel) {
                    $page->where('id', $channel->id)
                        ->where('title', $channel->title);
                });
        });
});
