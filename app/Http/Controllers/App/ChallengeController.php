<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with(['banners', 'category'])->get();

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
    public function store(Request $request)
    {
        abort_if(! $request->user()->isOrga(), 403);

        $data = $this->validate($request, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['string'],
            'banners' => ['required', 'array', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'quantity' => ['required', 'numeric', 'min:1']
        ]);

        $creator = $request->user();
        $data['author_id'] = $creator->id;
        $data['team_id'] = null;

        $data['source'] = 'Orga';
        $challenge = Challenge::create($data);

        $challenge->banners()->sync($data['banners']);

        return redirect()->route('app.challenge.index');
    }

    /**
     * Show the form for editing an existing resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $challenge = Challenge::with('banners')->findOrFail($id);

        return Inertia::render('challenge/Edit', [
            'challenge' => $challenge,
            'banners' => Banner::all(),
            'categories' => Category::all()->keyBy('id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        abort_if(! $request->user()->isOrga(), 403);

        $data = $this->validate($request, [
            'id' => ['required', 'exists:challenges,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'banners' => ['array', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'quantity' => ['required', 'numeric', 'min:1']
        ]);

        $challenge = Challenge::findOrFail($data['id']);

        $challenge->title = $data['title'];
        $challenge->description = $data['description'];
        $challenge->category_id = $data['category_id'];
        $challenge->quantity = $data['quantity'];
        $challenge->save();
        $challenge->banners()->sync($data['banners']);

        return redirect()->route('app.challenge.index');
    }

    /**
     * Publish the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish(Request $request, int $id)
    {
        abort_if(! $request->user()->isOrga(), 403);

        $challenge = Challenge::findOrFail($id);
        $challenge->published_at = now();
        $challenge->save();

        return redirect()->route('app.challenge.index');
    }

    /**
     * Unpublish the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpublish(Request $request, int $id)
    {
        abort_if(! $request->user()->isOrga(), 403);

        $challenge = Challenge::findOrFail($id);
        $challenge->published_at = null;
        $challenge->save();

        return redirect()->route('app.challenge.index');
    }

    /**
     * Delete the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, int $id)
    {
        abort_if(! $request->user()->isOrga(), 403);

        $challenge = Challenge::findOrFail($id);
        $challenge->delete();

        return redirect()->route('app.challenge.index');
    }
}
