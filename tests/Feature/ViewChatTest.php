<?php

use App\Models\Channel;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('chat page redirects guest to login page', function () {
    $this->get('/chat')
        ->assertRedirect('/login');
});

test('chat page renders for authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get('/chat')
        ->assertStatus(200);
});

test('chat page shows user channels', function () {
    $user = User::factory()->create();
    $channels = Channel::factory()->count(4)->create();

    $channels[0]->users()->syncWithoutDetaching($user->id);
    $channels[1]->users()->syncWithoutDetaching($user->id);
    $channels[2]->users()->syncWithoutDetaching($user->id);

    $this->actingAs($user)
        ->get('/chat')
        ->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page) use ($channels) {
            $page->component('Chat/ChatHome')
                ->has('channels', 3, function (AssertableInertia $page) {
                    $page->hasAll(['id', 'title']);
                });
        });
});
