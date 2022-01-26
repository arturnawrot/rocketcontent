<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedisTest extends TestCase
{
    /** @test */
    public function checks_redis_availability()
    {
        Redis::connection();
        $this->expectNotToPerformAssertions();
    }
}
