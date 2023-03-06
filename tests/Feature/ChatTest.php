<?php

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;

test('user can join a channel', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels/' . $channel->id . '/join');

    $response->assertRedirect();

    // assert we see the channel in the user's channels
    $this->assertDatabaseHas('channel_user', [
        'user_id' => $user->id,
        'channel_id' => $channel->id,
    ]);

    // $response->assertStatus(200)
    //     // ->assertJson([
    //     //     'channels' => [
    //     //         'id' => $channel->id,
    //     //         'title' => $channel->title,
    //     //         'joined' => true,
    //     //     ],
    //     // ]);
});

test('user can leave a channel', function () {
    $user = User::factory()->create();
    $channel = Channel::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/api/channels/' . $channel->id . '/join');

    $response->assertRedirect();

    // assert we see the channel in the user's channels
    $this->assertDatabaseHas('channel_user', [
        'user_id' => $user->id,
        'channel_id' => $channel->id,
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

    // assert we do not see the channel in the user's channels
    $this->assertDatabaseMissing('channel_user', [
        'user_id' => $user->id,
        'channel_id' => $channel->id,
    ]);
});

test('user can optionally fetch only channels they havent joined', function () {
    $user = User::factory()->create();
    $channels = Channel::factory()->count(4)->create();

    $this->actingAs($user);

    $channels[0]->users()->syncWithoutDetaching($user->id);

    $response = $this->get('/api/channels?joined=false');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'channels')
        ->assertJson([
            'channels' => [
                [
                    'id' => $channels[1]->id,
                    'title' => $channels[1]->title,
                ],
                [
                    'id' => $channels[2]->id,
                    'title' => $channels[2]->title,
                ],
                [
                    'id' => $channels[3]->id,
                    'title' => $channels[3]->title,
                ],
            ],
        ]);

    $channels[1]->users()->syncWithoutDetaching($user->id);
    $channels[2]->users()->syncWithoutDetaching($user->id);

    $response = $this->get('/api/channels?joined=false');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'channels')
        ->assertJson([
            'channels' => [
                [
                    'id' => $channels[3]->id,
                    'title' => $channels[3]->title,
                ],
            ],
        ]);
});

test('user can fetch only channels theyve joined', function () {
    $user = User::factory()->create();
    $channels = Channel::factory()->count(4)->create();

    $this->actingAs($user);

    $response = $this->get('/api/channels');

    $response->assertStatus(200)
        ->assertJsonCount(0, 'channels');

    $channels[0]->users()->syncWithoutDetaching($user->id);

    $response = $this->get('/api/channels');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'channels')
        ->assertJson([
            'channels' => [
                [
                    'id' => $channels[0]->id,
                    'title' => $channels[0]->title,
                ],
            ],
        ]);

    $channels[1]->users()->syncWithoutDetaching($user->id);
    $channels[2]->users()->syncWithoutDetaching($user->id);

    $response = $this->get('/api/channels');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'channels')
        ->assertJson([
            'channels' => [
                [
                    'id' => $channels[0]->id,
                    'title' => $channels[0]->title,
                ],
                [
                    'id' => $channels[1]->id,
                    'title' => $channels[1]->title,
                ],
                [
                    'id' => $channels[2]->id,
                    'title' => $channels[2]->title,
                ],
            ],
        ]);
});

test('user can fetch channels with the right data', function () {
    $user = User::factory()->create();
    $channels = Channel::factory()->hasMessages(5)->count(4)->create();

    $channels[0]->users()->syncWithoutDetaching($user->id);
    $channels[1]->users()->syncWithoutDetaching($user->id);
    $channels[2]->users()->syncWithoutDetaching($user->id);
    $channels[3]->users()->syncWithoutDetaching($user->id);

    $this->actingAs($user);

    $response = $this->get('/api/channels');

    $response->assertStatus(200)
        ->assertJsonCount(4, 'channels')
        ->assertJsonStructure([
            'channels' => [
                '*' => [
                    'id',
                    'title',
                    'lastMessage' => [
                        'id',
                        'content',
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
            'channels' => [
                [
                    'id' => 1,
                    'title' => $channels[0]->title,
                    'lastMessage' => [
                        'id' => $channels[0]->messages[0]->id,
                        'content' => $channels[0]->messages[0]->content,
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
                        'content' => $channels[1]->messages[0]->content,
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
                        'content' => $channels[2]->messages[0]->content,
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
                        'content' => $channels[3]->messages[0]->content,
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

test('user can fetch messages with the right data', function () {
    $messages = Message::factory()->count(5)->create();

    $this->actingAs(User::factory()->create());

    $response = $this->get('/api/messages');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'messages')
        ->assertJsonStructure([
            'messages' => [
                '*' => [
                    'id',
                    'content',
                    'user' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ])
        ->assertJson([
            'messages' => [
                [
                    'id' => 1,
                    'content' => $messages[0]->content,
                    'user' => [
                        'id' => $messages[0]->user_id,
                        'name' => $messages[0]->user->name,
                    ],
                ],
                [
                    'id' => 2,
                    'content' => $messages[1]->content,
                    'user' => [
                        'id' => $messages[1]->user_id,
                        'name' => $messages[1]->user->name,
                    ],
                ],
                [
                    'id' => 3,
                    'content' => $messages[2]->content,
                    'user' => [
                        'id' => $messages[2]->user_id,
                        'name' => $messages[2]->user->name,
                    ],
                ],
                [
                    'id' => 4,
                    'content' => $messages[3]->content,
                    'user' => [
                        'id' => $messages[3]->user_id,
                        'name' => $messages[3]->user->name,
                    ],
                ],
                [
                    'id' => 5,
                    'content' => $messages[4]->content,
                    'user' => [
                        'id' => $messages[4]->user_id,
                        'name' => $messages[4]->user->name,
                    ],
                ],
            ],
        ]);
});
