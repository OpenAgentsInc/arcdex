<?php

use App\Models\Channel;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('discover page responds successfully', function () {
    $this->get('/discover')
        ->assertStatus(200);
});

test('discover page for authed users returns their joined channels in the channels prop', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $channel1 = Channel::factory()->create();
    $channel2 = Channel::factory()->create();
    $channel3 = Channel::factory()->create();
    $channel4 = Channel::factory()->create();
    $channel5 = Channel::factory()->create();

    $user->channels()->attach($channel1);
    $user->channels()->attach($channel2);
    $user->channels()->attach($channel3);

    $this->get('/discover')
        ->assertInertia(function (AssertableInertia $page) use ($channel1, $channel2, $channel3) {
            $page->component('Discover/Index')
                ->has('channels', 3, function (AssertableInertia $page) use ($channel1, $channel2, $channel3) {
                    $page->where('id', $channel1->id)
                        ->where('title', $channel1->title)
                        ->where('relayurl', $channel1->relayurl)
                        ->where('eventid', $channel1->eventid);
                    $page->hasAll(['id', 'title', 'eventid', 'relayurl']);
                });
        });
});

test('discover page, for guests, has discoverChannels props equal to all channels', function () {
    $channel1 = Channel::factory()->create();
    $channel2 = Channel::factory()->create();
    $channel3 = Channel::factory()->create();
    $channel4 = Channel::factory()->create();
    $channel5 = Channel::factory()->create();

    $this->get('/discover')
        ->assertInertia(function (AssertableInertia $page) use ($channel1, $channel2, $channel3, $channel4, $channel5) {
            $page->component('Discover/Index')
                ->has('discoverChannels', 5, function (AssertableInertia $page) use ($channel1, $channel2, $channel3, $channel4, $channel5) {
                    $page->where('id', $channel1->id)
                        ->where('title', $channel1->title)
                        ->where('relayurl', $channel1->relayurl)
                        ->where('eventid', $channel1->eventid);
                    $page->hasAll(['id', 'title', 'eventid', 'relayurl']);
                });
        });
});

test('discover page has discoverChannel props equal to all channels authed user has not joined', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $channel1 = Channel::factory()->create();
    $channel2 = Channel::factory()->create();
    $channel3 = Channel::factory()->create();
    $channel4 = Channel::factory()->create();
    $channel5 = Channel::factory()->create();

    $user->channels()->attach($channel1);
    $user->channels()->attach($channel2);

    $this->actingAs($user)
        ->get('/discover')
        ->assertInertia(function (AssertableInertia $page) use ($channel3) {
            $page->component('Discover/Index')
                ->has('discoverChannels', 3, function (AssertableInertia $page) use ($channel3) {
                    $page->where('id', $channel3->id)
                        ->where('title', $channel3->title)
                        ->where('relayurl', $channel3->relayurl)
                        ->where('eventid', $channel3->eventid);
                    $page->hasAll(['id', 'title', 'eventid', 'relayurl']);
                });
        });
});
