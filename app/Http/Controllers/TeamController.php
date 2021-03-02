<?php

namespace App\Http\Controllers;

use App\Models\Stamm;
use App\Models\Stufe;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return Inertia::render('team/Index', [
            'teams' => $user->teams->map->only(['id', 'name']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('team/Create', [
            'bezirke' => Stamm::groupedByBezirk(),
            'stufen' => Stufe::pluck('name', 'id'),
            'distances' => [
                10 => 'nah',
                100 => 'mittel',
                1000 => 'weit',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string'],
            'stamm_id' => ['required', 'exists:staemme,id'],
            'stufe_id' => ['required', 'exists:stufen,id'],
            'size' => ['required', 'integer', 'min:1'],
            'location' => ['required', 'array'],
            'location.lat' => ['required', 'numeric'],
            'location.lng' => ['required', 'numeric'],
            'radius' => ['required', 'integer', 'min:1'],
        ]);
        $data['join_code'] = Str::lower(Str::random(8));

        $creator = $request->user();
        $data['leader_id'] = $creator->id;

        $creator->teams()->create($data);

        return redirect()->route('app.team.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
