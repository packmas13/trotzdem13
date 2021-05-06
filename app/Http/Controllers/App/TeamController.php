<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserTeam;
use App\Models\Banner;
use App\Models\Team;
use App\Models\Troop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
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
        $teams->load('users', 'troop', 'district', 'banner', 'currentChallenges.banners', 'currentChallenges.category');
        // uncomment the following line to let the users see the handovers
        $teams->load('handovers.banner');

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
                1 => 'Bis zu Nachbarstämmen',
                2 => 'Überall im Bezirk',
                3 => 'Bis zu Nachbarbezirken',
                4 => 'Überall in der Diözese',
                5 => 'Wir kennen keine Grenzen'
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
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string'],
            'contact_street' => ['required', 'string'],
            'contact_zip' => ['required', 'string'],
            'contact_city' => ['required', 'string'],
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function image(Request $request, Team $team)
    {
        $data = $this->validate($request, [
            'image' => ['nullable', 'file', 'image'],
        ]);

        abort_unless($request->user()->can('changeImage', $team), 403, 'Access denied. Only the Team leader can change the image');

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

        $team->image = $data['image'];
        $team->save();

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
