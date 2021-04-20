<?php

namespace Tests\Feature\challenge;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_index_page()
    {
        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->hasChallenges(1)->create());

        $response = $this->get('/app/orga/challenge');

        $response->assertStatus(200);

        $data = $response->viewData('page')['props'];
        $this->assertArrayHasKey('challenges', $data);
        $this->assertCount(1, $data['challenges']);
        $this->assertIsInt($data['challenges'][0]['quantity']);
        $this->assertIsInt($data['challenges'][0]['teams_count']);
    }

    public function test_get_create_page()
    {
        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->get('/app/orga/challenge/create');

        $response->assertStatus(200);
    }


    public function test_post_new_challenge()
    {
        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->post('/app/orga/challenge', [
            'title' => 'My mega challenge',
            'description' => 'Develop a full website in a couple of days',
            'category_id' => 1,
            'quantity' => 1,
            'banners' => [1, 3], // Wölfling + Pfadi

        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        // challenge was created
        $challenge = Challenge::latest()->firstOrFail();
        $this->assertEquals($challenge->author_id, $user->id);

        $this->assertEquals($challenge->title, 'My mega challenge');
    }

    public function test_delete_challenge()
    {
        $challenge = Challenge::factory()->create();
        $this->assertFalse($challenge->trashed());

        $this->actingAs($user = User::factory()->belongingToOrgaTeam()->create());
        $response = $this->delete('/app/orga/challenge/delete/' . $challenge->id);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertTrue($challenge->fresh()->trashed());
    }
}
