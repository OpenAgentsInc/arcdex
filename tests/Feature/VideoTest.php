<?php

use App\Http\Controllers\VideoController;
use Inertia\Testing\AssertableInertia as Assert;

test('videos page has videos', function () {
    $response = $this->get('/videos');

   // get the number of videos from the VideoController getVideos method
    $videoCount = count((new VideoController())->getVideos());

    $response->assertStatus(200);
    $response->assertInertia(function (Assert $page) use ($videoCount) {
            $page->has('videos', $videoCount, function (Assert $video) {
                $video->hasAll([
                    'id',
                    'title',
                    'subtitle',
                    'url',
                ]);
            });
        });
});

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
