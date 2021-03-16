<?php

namespace Tests\Feature\team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_index_page()
    {
        $this->actingAs($user = User::factory()->hasTeams(1)->create());

        $response = $this->get('/app/team');

        $response->assertStatus(200);

        $data = $response->viewData('page')['props'];
        $this->assertArrayHasKey('teams', $data);
    }
}
