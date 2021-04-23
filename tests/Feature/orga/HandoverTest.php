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
            'variant' => 2,
        ]);

        $response->assertStatus(201);

        $handover = $team->handovers->first();
        $this->assertNotNull($handover);
        $this->assertEquals(2, $handover->variant);

        $nextHandover = $handover->nextHandover();
        $this->assertNotNull($nextHandover);
        $this->assertEquals(42, $nextHandover->team->id);
    }

    public function test_update_a_handover()
    {
        $handover = Handover::factory()->create();

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->put('/app/orga/handover/' . $handover->id, [
            'team_id' => $handover->team_id,
            'banner_id' => $handover->banner_id,
            'received_at' => '2021-05-01',
            'variant' => 2,
        ]);

        $response->assertStatus(200);

        $handover->refresh();

        $this->assertEquals('2021-05-01', $handover->received_at->format('Y-m-d'));
        $this->assertEquals(2, $handover->variant);
    }
}
