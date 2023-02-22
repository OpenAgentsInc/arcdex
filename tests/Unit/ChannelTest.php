<?php

use App\Models\Channel;
use App\Models\User;

test('user has unjoined channels', function () {
    $user = User::factory()->create();
    $channel1 = Channel::factory()->create();
    $channel2 = Channel::factory()->create();
    $channel3 = Channel::factory()->create();
    $channel4 = Channel::factory()->create();
    $channel5 = Channel::factory()->create();

    $user->channels()->attach($channel1);
    $user->channels()->attach($channel2);

    $unjoinedChannels = $user->fresh()->unjoinedChannels;

    $this->assertTrue($unjoinedChannels->contains($channel3));
    $this->assertTrue($unjoinedChannels->contains($channel4));
    $this->assertTrue($unjoinedChannels->contains($channel5));
    $this->assertFalse($unjoinedChannels->contains($channel1));
    $this->assertFalse($unjoinedChannels->contains($channel2));
});
