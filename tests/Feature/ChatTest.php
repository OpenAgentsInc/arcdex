<?php

use App\Models\Message;
use App\Models\User;

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
