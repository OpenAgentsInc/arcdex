<?php

use App\Models\User;

test('user can logout', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->assertAuthenticated();

    $response = $this->post('/logout');

    $response
        ->assertStatus(302)
        ->assertRedirect('/');

    $this->assertGuest();
});
