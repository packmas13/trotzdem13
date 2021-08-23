<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Banner;
use App\Models\Challenge;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $query = Post::query();
        if($request->filled('team')) {
            $query->where('team_id', $request->get('team'));
        }
        if($request->filled('banner')) {
            $query->where('banner_id', $request->get('banner'));
        }
        if($request->filled('project')) {
            $query->where('challenge_id', $request->get('project'));
        }
        if($request->filled('hashtag')) {
            $query->where('content', 'LIKE', '%'.$request->get('hashtag').'%');
        }

        $posts = $query->with(['author', 'team', 'banner', 'challenge', 'comments', 'comments.author', 'users'])->orderByDesc('updated_at')->get();

        $user = $request->user();
        $teams = $user->teams()->whereNotNull('approved_at')->get();
        $teams->load('banner', 'currentChallenges', 'challenges');

        PostResource::withoutWrapping();
        return Inertia::render('post/Index', [
            'posts' => PostResource::collection($posts),
            'banners' => Banner::all()->keyBy('id'),
            'challenges' => Challenge::all(),
            'teams' => $teams,
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
            'subject' => ['required', 'string'],
            'content' => ['required', 'string'],
            'team_id' => ['required', 'exists:teams,id', 'in:'.$request->user()->teams()->whereNotNull('approved_at')->pluck('id')->join(',')],
            'banner_id' => ['nullable', 'exists:banners,id'],
            'challenge_id' => ['nullable', 'exists:challenges,id'],
            'image' => ['nullable', 'file', 'image'],
            'video' => ['nullable', 'string'],
        ]);

        $author = $request->user();
        $data['author_id'] = $author->id;

        if (!empty($data['image'])) {
            // save original image
            $imageOriginal = Image::make($data['image']);
            $filename = 'post/originals/' . $data['image']->hashName();
            Storage::disk('upload')->put($filename, $imageOriginal->encode());

            // save preview version
            $imagePreview = Image::make($data['image'])->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $data['image'] = 'post/' . $data['image']->hashName();
            Storage::disk('upload')->put($data['image'], $imagePreview->encode());
        } else {
            $data['image'] = '';
        }

        if(!isset($data['video'])){
            $data['video'] = '';
        }

        $post = Post::create($data);

        return redirect()->route('app.post.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function edit(Request $request, Post $post)
    {
        abort_unless($request->user()->can('edit', $post), 403, 'Access denied. Only the Author can edit the post');

        $post->load('team.challenges', 'team.currentChallenges', 'team.banner');
        $post->imageUrl = empty($post->image) ? null : Storage::disk('upload')->url($post->image);

        return Inertia::render('post/Edit', [
            'post' => $post,
            'banner' => Banner::all()->keyBy('id'),
            'challenges' => Challenge::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        $data = $this->validate($request, [
            'subject' => ['required', 'string'],
            'content' => ['required', 'string'],
            'banner_id' => ['nullable', 'exists:banners,id'],
            'challenge_id' => ['nullable', 'exists:challenges,id'],
            'image' => ['nullable', 'file', 'image'],
            'video' => ['nullable', 'string'],
            'removeImage' => ['nullable', 'bool'],
        ]);

        abort_unless($request->user()->can('edit', $post), 403, 'Access denied. Only the Author can edit the post');

        $post->subject = $data['subject'];
        $post->content = $data['content'];
        $post->banner_id = $data['banner_id'];
        $post->challenge_id = $data['challenge_id'];
        $post->video = $data['video'] ?? '';

        if(isset($data['removeImage']) && $data['removeImage'] && $post->image){
            Storage::disk('upload')->delete($post->image);
            $post->image = '';
        }

        if (!empty($data['image'])) {
            // save original image
            $imageOriginal = Image::make($data['image']);
            $filename = 'post/originals/' . $data['image']->hashName();
            Storage::disk('upload')->put($filename, $imageOriginal->encode());

            // save preview version
            $imagePreview = Image::make($data['image'])->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $data['image'] = 'post/' . $data['image']->hashName();
            Storage::disk('upload')->put($data['image'], $imagePreview->encode());

            $post->image = $data['image'];
        }

        $post->save();

        return redirect()->route('app.post.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
     * React on a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function react(Request $request)
    {
        $data = $this->validate($request, [
            'type' => ['required', 'string'],
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        $user = $request->user();

        $post = Post::findOrFail($data['post_id']);

        $post->users()->syncWithoutDetaching([$user->id => ['type' => $data['type']]]);

        return redirect()->route('app.post.index');
    }

    /**
     * React on a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unreact(Request $request)
    {
        $data = $this->validate($request, [
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        $user = $request->user();

        $post = Post::findOrFail($data['post_id']);

        $post->users()->detach($user->id);

        return redirect()->route('app.post.index');
    }

    /**
     * Delete the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Post $post)
    {
        abort_unless($request->user()->can('delete', $post), 403, 'Access denied. Only the Author can delete the post');

        $post->delete();

        return redirect()->route('app.post.index');
    }
}
