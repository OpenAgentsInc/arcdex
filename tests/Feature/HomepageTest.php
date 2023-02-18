<?php

test('homepage renders', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
