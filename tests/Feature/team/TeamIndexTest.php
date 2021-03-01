<?php

namespace Tests\Feature\team;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_index_page()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/app/team');

        $response->assertStatus(200);
    }
}
