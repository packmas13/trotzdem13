<?php

namespace Tests\Feature\team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_list()
    {
        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->get('/app/orga/team/approval/pending');

        $response->assertStatus(200);
    }

    public function test_approve_team()
    {
        $team = Team::factory()->pending()->create();
        $this->assertNull($team->approved_at);

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->post('/app/orga/team/approval', [
            'approved' => '1',
            'team_id' => $team->id,
            'reason' => '',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $team->refresh();
        $this->assertNotNull($team->approved_at);
    }

    public function test_delete_team_with_a_reason()
    {
        $team = Team::factory()->pending()->create();
        $this->assertNull($team->approved_at);
        $this->assertNull($team->deleted_at);

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->post('/app/orga/team/approval', [
            'approved' => '0',
            'team_id' => $team->id,
            'reason' => 'Spam or whatever',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $team->refresh();
        $this->assertNull($team->approved_at);
        $this->assertNotNull($team->deleted_at);
        $this->assertEquals('Spam or whatever', $team->deletion_reason);
    }
}
