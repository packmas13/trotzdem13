<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with(['author', 'team', 'banner', 'challenge', 'comments'])->orderByDesc('updated_at')->get();
        $posts = $posts->each(function($post){$post->team->image = ($post->team->image) ? Storage::disk('upload')->url($post->team->image) : null;});

        $user = $request->user();
        $teams = $user->teams;
        $teams->load('banner', 'currentChallenges');

        return Inertia::render('post/Index', [
            'posts' => $posts,
            'banners' => Banner::all()->keyBy('id'),
            'teams' => $teams,
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
            'subject' => ['required', 'string'],
            'content' => ['required', 'string'],
            'team_id' => ['required', 'exists:teams,id'],
            'banner_id' => ['nullable', 'exists:banners,id'],
            'challenge_id' => ['nullable', 'exists:challenges,id'],
        ]);

        $author = $request->user();
        $data['author_id'] = $author->id;

        $post = Post::create($data);

        return redirect()->route('app.post.index');
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
