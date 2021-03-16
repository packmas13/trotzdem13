<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Stufe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ChallengeController extends Controller
{
    public function index()
    {
        // TODO: reduce to only published
        $list = Challenge::whereNotNull('published_at');

        $challenges = [];
        foreach($list as $challenge){
            $challenges[] = [
                'title' => $challenge->title,
                'description' => $challenge->description,
            ];
        }

        return view('challenge.index', [
            'challenges' => $challenges
        ]);
    }

    public function list()
    {
        $list = Challenge::all();

        $challenges = [];
        foreach($list as $challenge){
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
            'stufen' => Stufe::pluck('name', 'id'),
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
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['string']
        ]);
        $data['author_id'] = Str::lower(Str::random(8));

        $creator = $request->user();
        $data['author_id'] = $creator->id;

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
            'stufen' => Stufe::pluck('name', 'id'),
            'categories' => Category::pluck('title', 'id'),
        ]);
    }
}
