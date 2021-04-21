<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Challenge;
use App\Models\Comment;
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
        $posts = Post::with(['author', 'team', 'banner', 'challenge', 'comments', 'comments.author'])->orderByDesc('updated_at')->get();
        $posts = $posts->each(function($post){$post->team->image = ($post->team->image) ? Storage::disk('upload')->url($post->team->image) : null;});

        $user = $request->user();
        $teams = $user->teams;
        $teams->load('banner');

        return Inertia::render('post/Index', [
            'posts' => $posts,
            'banners' => Banner::all()->keyBy('id'),
            'challenges' => Challenge::all(),
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
            'banner_id' => ['nullable', 'requiredIf:banner_related,true', 'exists:banners,id'],
            'challenge_id' => ['nullable', 'requiredIf:challenge_related,true', 'exists:challenges,id'],
            'banner_related' => ['boolean', 'required'],
            'challenge_related' => ['boolean', 'required'],
        ]);

        $author = $request->user();
        $data['author_id'] = $author->id;

        if(!$data['banner_related']){
            $data['banner_id'] = null;
        }

        if(!$data['challenge_related']){
            $data['challenge_id'] = null;
        }

        $post = Post::create($data);

        return redirect()->route('app.post.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        $data = $this->validate($request, [
            'content' => ['required', 'string'],
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        $author = $request->user();
        $data['author_id'] = $author->id;

        $post = Comment::create($data);

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
