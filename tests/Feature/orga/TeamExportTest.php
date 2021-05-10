<?php

namespace Tests\Feature\orga;

use App\Exports\TeamExport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class TeamExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_all_users_addresses()
    {
        Excel::fake();

        $exported = Team::factory()->create();
        $notExportedPending = Team::factory()->pending()->create();
        $notExportedDeleted = Team::factory()->trashed()->create();

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->get('/app/orga/export/teams.ods');

        $response->assertStatus(200);

        Excel::assertDownloaded('trotzdem13-teams.ods', function (TeamExport $export) use ($exported) {
            $array = $export->array();
            $this->assertCount(1, $array);
            $this->assertEquals($exported->contact_street, $array[0]['contact_street']);
            return true;
        });
    }
}
