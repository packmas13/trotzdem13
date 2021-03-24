<?php

namespace Tests\Feature\command;

use App\Models\Challenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChallengeImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_csv_import()
    {
        $this->assertEquals(0, Challenge::count());
        $path = dirname(__FILE__);
        $this->artisan('t13:import-challenges '.$path.'/Projektliste.csv')->assertExitCode(0);

        $this->assertEquals(41, Challenge::count());

        // duplicates are ignored
        $this->artisan('t13:import-challenges '.$path.'/Projektliste.csv')->assertExitCode(0);
        $this->assertEquals(41, Challenge::count());
    }
}
