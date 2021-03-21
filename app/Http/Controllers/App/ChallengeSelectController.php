<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserTeam;
use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChallengeSelectController extends Controller
{
    public function selection(Request $request, int $team_id)
    {
        $team = Team::findOrFail($team_id);

        $leader = $request->user();

        $challenges = Challenge::with(['banners', 'category'])->whereNotNull('published_at')->get();

        return Inertia::render('challenge/Selection', [
            'challenges' => $challenges,
            'team' => $team,
            'isLeader' => $team->leader_id == $leader->id
        ]);
    }

    public function select(Request $request, int $team_id, int $challenge_id)
    {
        $team = Team::doesntHave('currentChallenges')->findOrFail($team_id);
        $challenge = Challenge::findOrFail($challenge_id);

        $bookedTeamsCount = $challenge->teams()->count();
        if($challenge->quantity > $bookedTeamsCount){
            if($request->user()->id == $team->leader_id){
                $challenge->teams()->syncWithoutDetaching([$team->id]);
            }
        }
        return redirect()->route('app.team.index');
    }
}
