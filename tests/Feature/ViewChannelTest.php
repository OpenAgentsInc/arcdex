<?php

use App\Models\Channel;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('user can visit a new channel page and see 0 messages', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/channel/' . $channel->id);

    $response->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page) use ($channel) {
            $page->component('Chat/Channel')
                ->has('channel', function (AssertableInertia $page) use ($channel) {
                    $page->where('id', $channel->id)
                        ->where('title', $channel->title);
                })
                ->has('messages', 0);
        });
});

test('user can visit a channel page and see its messages', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->hasMessages(5)->create();

    $this->actingAs($user);

    $response = $this->get('/channel/' . $channel->id);

    $response->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page) use ($channel) {
            $page->component('Chat/Channel')
                ->has('channel', function (AssertableInertia $page) use ($channel) {
                    $page->where('id', $channel->id)
                        ->where('title', $channel->title);
                })
                ->has('messages', 5, function (AssertableInertia $page) {
                    $page->hasAll(['id', 'content', 'created_at', 'eventid', 'relayurl']);
                });
        });
});
