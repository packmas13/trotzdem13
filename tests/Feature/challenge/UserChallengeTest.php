<?php

namespace Tests\Feature\challenge;

use App\Models\Challenge;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_index_page()
    {
        $this->actingAs($user = User::factory()->hasChallenges(1)->create());

        $response = $this->get('/app/challenge');

        $response->assertStatus(200);

        $data = $response->viewData('page')['props'];
        $this->assertArrayHasKey('challenges', $data);
    }

    public function test_get_create_page()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/app/challenge/create');

        $response->assertStatus(200);
    }


    public function test_post_new_challenge()
    {
        // $this->withExceptionHandling();
        $this->actingAs($user = User::factory()->create());
        $response = $this->post('/app/challenge', [
            'title' => 'My mega challenge',
            'description' => 'Develop a full website in a couple of days'
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        // challenge was created
        $challenge = Challenge::latest()->firstOrFail();
        $this->assertEquals($challenge->author_id, $user->id);

        $this->assertEquals($challenge->name, 'Polarfüchse');
    }
}
