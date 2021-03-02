<?php

namespace Tests\Feature\team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_create_page()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/app/team/create');

        $response->assertStatus(200);
    }

    public function test_post_new_team()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->post('/app/team', [
            'name' => 'Polarfüchse',
            'stamm_id' => '132010',
            'stufe_id' => 1, // Wölflinge
            'size' => 5,
            'location' => ["lat" => 47.76116644679894, "lng" => 11.562785434513446],
            'radius' => 4,
        ]);
        $response->assertStatus(302);

        // team was created
        $team = Team::latest()->firstOrFail();
        $this->assertEquals($team->leader->id, $user->id);
        $this->assertEquals($team->name, 'Polarfüchse');
        $this->assertEquals($team->stamm->name, 'Bad Tölz');
        $this->assertEquals($team->stufe->name, 'Wölflinge');
        $this->assertEquals($team->size, 5);
        $this->assertEquals($team->location, [
            "lat" => 47.76116644679894,
            "lng" => 11.562785434513446,
        ]);
        $this->assertEquals($team->radius, 4);

        // auto-generated code
        $this->assertNotNull($team->join_code);
        $this->assertGreaterThanOrEqual(8, strlen($team->join_code));

        $this->assertNull($team->approved_at);

        // user is associated to the team
        $teams = $user->teams;
        $this->assertCount(1, $teams);
        $this->assertEquals($team->id, $teams->first()->id);
    }
}
