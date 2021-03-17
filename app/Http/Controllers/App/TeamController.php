<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserTeam;
use App\Models\Banner;
use App\Models\Troop;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
        $teams = $user->teams;
        $teams->load('users', 'troop', 'district', 'banner');
        UserTeam::withoutWrapping();
        return Inertia::render('team/Index', [
            'teams' => UserTeam::collection($teams),
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
            'districts' => Troop::groupedByDistrict(),
            'banners' => Banner::all()->keyBy('id'),
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
            'troop_id' => ['required', 'exists:troops,id'],
            'banner_id' => ['required', 'exists:banners,id'],
            'size' => ['required', 'integer', 'min:1'],
            'location' => ['required', 'array'],
            'location.lat' => ['required', 'numeric'],
            'location.lng' => ['required', 'numeric'],
            'radius' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'file', 'image'],
        ]);
        $data['join_code'] = Str::lower(Str::random(8));

        $creator = $request->user();
        $data['leader_id'] = $creator->id;

        if (!empty($data['image'])) {
            // resize image before storing
            $image = Image::make($data['image'])->resize(512, 512, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $data['image'] = 'team/profile/' . $data['image']->hashName();
            Storage::disk('upload')->put($data['image'], $image->encode());
        } else {
            $data['image'] = '';
        }

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
