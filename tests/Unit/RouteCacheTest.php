<?php

namespace Tests\Unit;

use Tests\TestCase;

class RouteCacheTest extends TestCase
{
    public function test_artisan_route_cache()
    {
        $this->artisan('route:cache')->assertExitCode(0);
        $this->artisan('route:clear')->assertExitCode(0);
    }
}
