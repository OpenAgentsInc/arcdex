<?php

use App\Models\User;

test('the login page renders', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});


test('login endpoint expects pubkey', function () {
    User::factory()->create([
        'pubkey' => 'test'
    ]);

    $this->post('/login', [
        'pubkey' => 'test'
    ])
        ->assertStatus(200)
        ->assertValid()
        ->assertJson([
            'message' => 'success'
        ]);

    $this->post('/login')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['pubkey']);
});


test('login endpoint logs in a user', function () {
    User::factory()->create([
        'pubkey' => '12345'
    ]);

    $this->post('/login', [
        'pubkey' => '12345'
    ])
        ->assertStatus(200)
        ->assertValid()
        ->assertJson([
            'message' => 'success'
        ]);

    $this->assertAuthenticated();

    // let's test if we're authed by trying to fetch our channels
    $this->get('/api/channels')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'joined',
                    'lastMessage'
                ]
            ]
        ]);
});

test('login endpoint creates a new user if none exists', function () {
    $this->post('/login', [
        'pubkey' => '12345'
    ])
        ->assertStatus(200)
        ->assertValid()
        ->assertJson([
            'message' => 'success'
        ]);

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'pubkey' => '12345'
    ]);
});
