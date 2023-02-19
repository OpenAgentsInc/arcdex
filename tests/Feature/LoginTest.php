<?php

test('the login page renders', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});
