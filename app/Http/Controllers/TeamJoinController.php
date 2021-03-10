<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamJoinController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show()
    {
        return Inertia::render('team/Join');
    }

    /**
     * Background Route for joining Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'code' => ['required', 'string', 'exists:teams,join_code'],
        ]);

        $team = Team::where('join_code', $data['code'])->firstOrFail();

        $user = $request->user();
        $user->teams()->syncWithoutDetaching([$team->id]);

        return redirect()->route('app.team.index');
    }
}
