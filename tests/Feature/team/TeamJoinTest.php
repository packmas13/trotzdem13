<?php

namespace Tests\Feature\team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamJoinTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_form()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/app/team/join-form');

        $response->assertStatus(200);
    }

    public function test_join_team()
    {
        $team = Team::factory()->create([
            'join_code' => 'secret',
        ]);
        $this->actingAs($user = User::factory()->create());
        $response = $this->post('/app/team/join', [
            'code' => 'secret',
        ]);

        $response->assertStatus(302);

        $teams = $user->teams()->get();
        $this->assertCount(1, $teams);
        $this->assertEquals($team->id, $teams->first()->id);

        $this->assertDatabaseCount('team_user', 1);
    }

    public function test_multijoin_team()
    {
        $team = Team::factory()->create([
            'join_code' => 'secret',
        ]);
        $this->actingAs($user = User::factory()->create());
        $response = $this->post('/app/team/join', [
            'code' => 'secret',
        ]);

        $response->assertStatus(302);

        // second attempt
        $response = $this->post('/app/team/join', [
            'code' => 'secret',
        ]);

        $response->assertStatus(302);

        $teams = $user->teams()->get();
        $this->assertCount(1, $teams);
        $this->assertEquals($team->id, $teams->first()->id);

        $this->assertDatabaseCount('team_user', 1);
    }

    public function test_invalid_code()
    {
        $this->withExceptionHandling();
        $team = Team::factory()->create([
            'join_code' => 'secret',
        ]);
        $this->actingAs($user = User::factory()->create());
        $response = $this->post('/app/team/join', [
            'code' => 'invalid',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'code',
        ]);

        $teams = $user->teams()->get();
        $this->assertCount(0, $teams);

        $this->assertDatabaseCount('team_user', 0);
    }
}
