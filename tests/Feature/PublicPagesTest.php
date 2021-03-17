<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_visit_homepage()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Trotzdem ’13');
    }


    /**
     * @dataProvider public_pages
     */
    public function test_public_pages($uri)
    {
        $this->withoutExceptionHandling();
        $response = $this->get($uri);

        $response->assertStatus(200);
    }

    public function public_pages():array
    {
        return [
            // name => arguments
            '/' => ['/'],
            '/karte' => ['/karte'],
            '/teilnehmer' => ['/teilnehmer'],
            '/challenges' => ['/challenges'],
            '/impressum' => ['/impressum'],
            '/datenschutz' => ['/datenschutz'],
        ];
    }
}
