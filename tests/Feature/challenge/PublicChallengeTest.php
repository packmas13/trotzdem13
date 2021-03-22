<?php

namespace Tests\Feature\challenge;

use App\Models\Challenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_index()
    {
        Challenge::factory(3)->create();
        $response = $this->get('/projekte');

        $response->assertStatus(200);
    }
}
