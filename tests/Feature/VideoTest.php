<?php

// test('building arc channel renders', function () {
//     $response = $this->get('/channel/building-arc');

//     $response->assertStatus(200)
//         ->assertViewIs('channel');
// });

test('video page renders', function () {
    $response = $this->get('/video/1');

    $response->assertStatus(200)
        ->assertViewIs('video');
});

test('video page shows correct video titles', function () {
    $this->get('/video/1')
        ->assertStatus(200)
        ->assertSee('Introduction');

    $this->get('/video/2')
        ->assertStatus(200)
        ->assertSee('Project Setup');

    $this->get('/video/3')
        ->assertStatus(200)
        ->assertSee('Deploy via Forge');

    $this->get('/video/4')
        ->assertStatus(200)
        ->assertSee('React+Tailwind Chat UI');
});
