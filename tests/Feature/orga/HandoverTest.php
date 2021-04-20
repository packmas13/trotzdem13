<?php

namespace Tests\Feature\orga;

use App\Models\Handover;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HandoverTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_handover()
    {
        $team = Team::factory()->create();

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->post('/app/orga/handover', [
            'team_id' => $team->id,
            'banner_id' => $team->banner_id,
            'received_at' => '2021-04-01',
        ]);

        $response->assertStatus(201);

        $handover = $team->first_handover();
        $this->assertNotNull($handover);

        $next_team = $handover->next_team();
        $this->assertNotNull($next_team);
        $this->assertEquals(42, $next_team->id);
    }

    public function test_update_a_handover()
    {
        $handover = Handover::factory()->create();

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->put('/app/orga/handover/' . $handover->id, [
            'team_id' => $handover->team_id,
            'banner_id' => $handover->banner_id,
            'received_at' => '2021-05-01',
        ]);

        $response->assertStatus(200);

        $handover->refresh();

        $this->assertEquals('2021-05-01', $handover->received_at->format('Y-m-d'));
    }
}
