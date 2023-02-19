<?php

test('the login page renders', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});


test('login endpoint expects pubkey', function () {
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
