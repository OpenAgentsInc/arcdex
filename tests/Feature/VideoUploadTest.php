<?php

use App\Http\Controllers\UploadController;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\post;
use function Spatie\PestPluginTestTime\testTime;

it('can handle an upload', function () {
    // log in as demo user
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->withoutExceptionHandling();
    testTime()->freeze('2021-01-01 00:00:00');

    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.jpg');

    post('/video-upload', [
        'file' => $file,
    ])
        ->assertSuccessful()
        ->assertSee('uploads/2021-01-01-00-00-00-test.jpg');

    Storage::disk('public')->assertExists('uploads/2021-01-01-00-00-00-test.jpg');
});
