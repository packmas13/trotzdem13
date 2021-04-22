<?php

namespace Tests\Feature\orga;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_all_users_email()
    {
        $notExported = User::factory()->create()->email;

        $exported = Team::factory()->create()->leader->email;
        $notExportedPending = Team::factory()->pending()->create()->leader->email;

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->get('/app/orga/export/team-users-emails');

        $response->assertStatus(200);
        $response->assertSee($exported);

        $response->assertDontSee($notExported);
        $response->assertDontSee($notExportedPending);
    }
}
