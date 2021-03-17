<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ChallengeController extends Controller
{
    public function index()
    {
        $list = Challenge::all();

        $challenges = [];
        foreach ($list as $challenge) {
            $challenges[] = [
                'id' => $challenge->id,
                'title' => $challenge->title,
                'description' => $challenge->description,
                'published_at' => $challenge->published_at,
                'category' => $challenge->category->title
            ];
        }

        return Inertia::render('challenge/List', [
            'challenges' => $challenges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('challenge/Create', [
            'banners' => Banner::pluck('name', 'id'),
            'categories' => Category::pluck('title', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['string']
        ]);
        $data['author_id'] = Str::lower(Str::random(8));

        $creator = $request->user();
        $data['author_id'] = $creator->id;
        $data['team_id'] = 0;

        $data['source'] = 'Orga';
        // TODO: set source to "Orga" if User is Orga-Member

        Challenge::create($data);

        return redirect()->route('app.challenge.list');
    }

    /**
     * Show the form for editing an existing resource.
     *
     * @param Request $request
     * @return Response
     */
    public function edit(int $id)
    {
        $challenge = Challenge::findOrFail($id);

        return Inertia::render('challenge/Edit', [
            'challenge' => $challenge,
            'banners' => Banner::pluck('name', 'id'),
            'categories' => Category::pluck('title', 'id'),
        ]);
    }
}
