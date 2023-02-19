<?php

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;

test('user can join a channel', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels/' . $channel->id . '/join');

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => true,
            ],
        ]);
});

test('user can leave a channel', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels/' . $channel->id . '/join');

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => true,
            ],
        ]);

    $response = $this->delete('/api/channels/' . $channel->id . '/join');

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $channel->id,
                'title' => $channel->title,
                'joined' => false,
            ],
        ]);
});

test('user can fetch channels from API endpoint', function () {
    $channels = Channel::factory()->hasMessages(5)->count(4)->create();

    $this->actingAs(User::factory()->create());

    $response = $this->get('/api/channels');

    $response->assertStatus(200)
        ->assertJsonCount(4, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'lastMessage' => [
                        'id',
                        'text',
                        'user' => [
                            'id',
                            'name',
                        ],
                        'created_at',
                    ],
                ],
            ],
        ])
        ->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'title' => $channels[0]->title,
                    'lastMessage' => [
                        'id' => $channels[0]->messages[0]->id,
                        'text' => $channels[0]->messages[0]->text,
                        'user' => [
                            'id' => $channels[0]->messages[0]->user_id,
                            'name' => $channels[0]->messages[0]->user->name,
                        ],
                        'created_at' => $channels[0]->messages[0]->created_at->format('Y-m-d\TH:i:s.u\Z')
                    ],
                ],
                [
                    'id' => 2,
                    'title' => $channels[1]->title,
                    'lastMessage' => [
                        'id' => $channels[1]->messages[0]->id,
                        'text' => $channels[1]->messages[0]->text,
                        'user' => [
                            'id' => $channels[1]->messages[0]->user_id,
                            'name' => $channels[1]->messages[0]->user->name,
                        ],
                        'created_at' => $channels[1]->messages[0]->created_at->format('Y-m-d\TH:i:s.u\Z')
                    ],
                ],
                [
                    'id' => 3,
                    'title' => $channels[2]->title,
                    'lastMessage' => [
                        'id' => $channels[2]->messages[0]->id,
                        'text' => $channels[2]->messages[0]->text,
                        'user' => [
                            'id' => $channels[2]->messages[0]->user_id,
                            'name' => $channels[2]->messages[0]->user->name,
                        ],
                        'created_at' => $channels[2]->messages[0]->created_at->format('Y-m-d\TH:i:s.u\Z')
                    ],
                ],
                [
                    'id' => 4,
                    'title' => $channels[3]->title,
                    'lastMessage' => [
                        'id' => $channels[3]->messages[0]->id,
                        'text' => $channels[3]->messages[0]->text,
                        'user' => [
                            'id' => $channels[3]->messages[0]->user_id,
                            'name' => $channels[3]->messages[0]->user->name,
                        ],
                        'created_at' => $channels[3]->messages[0]->created_at->format('Y-m-d\TH:i:s.u\Z')
                    ],
                ]
            ],
        ]);
});

test('user can fetch messages from API endpoint', function () {
    $messages = Message::factory()->count(5)->create();

    $this->actingAs(User::factory()->create());

    $response = $this->get('/api/messages');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'text',
                    'user' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ])
        ->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'text' => $messages[0]->text,
                    'user' => [
                        'id' => $messages[0]->user_id,
                        'name' => $messages[0]->user->name,
                    ],
                ],
                [
                    'id' => 2,
                    'text' => $messages[1]->text,
                    'user' => [
                        'id' => $messages[1]->user_id,
                        'name' => $messages[1]->user->name,
                    ],
                ],
                [
                    'id' => 3,
                    'text' => $messages[2]->text,
                    'user' => [
                        'id' => $messages[2]->user_id,
                        'name' => $messages[2]->user->name,
                    ],
                ],
                [
                    'id' => 4,
                    'text' => $messages[3]->text,
                    'user' => [
                        'id' => $messages[3]->user_id,
                        'name' => $messages[3]->user->name,
                    ],
                ],
                [
                    'id' => 5,
                    'text' => $messages[4]->text,
                    'user' => [
                        'id' => $messages[4]->user_id,
                        'name' => $messages[4]->user->name,
                    ],
                ],
            ],
        ]);
});
