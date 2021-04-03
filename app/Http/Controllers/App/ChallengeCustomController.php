<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChallengeCustomController extends Controller
{

    public function create(Request $request, int $team_id)
    {
        $team = Team::withCount('currentChallenges')->findOrFail($team_id);

        $leader = $request->user();

        return Inertia::render('challenge/Custom', [
            'team' => $team,
            'isLeader' => $team->leader_id == $leader->id,
            'banners' => Banner::all(),
            'categories' => Category::all()->keyBy('id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $team_id)
    {
        $team = Team::doesntHave('currentChallenges')->findOrFail($team_id);

        $data = $this->validate($request, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['string'],
            'banners' => ['required', 'array', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $creator = $request->user();
        $data['author_id'] = $creator->id;
        $data['team_id'] = $team_id;
        $data['quantity'] = 1;
        $data['submitted_at'] = now();

        $data['source'] = 'Team';
        $challenge = Challenge::create($data);

        $challenge->banners()->sync($data['banners']);
        $challenge->teams()->syncWithoutDetaching([$team_id]);

        return redirect()->route('app.team.index');
    }
}
