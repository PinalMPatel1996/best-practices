<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::filterByUserId(request()->user_id)->paginate();

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated() + ['user_id' => auth()->id()]);

        $post->saveFile($request->file);

        $post->load('user');

        return PostResource::make($post);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        $post->load(['user']);

        return PostResource::make($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->fill($request->validated())->save();

        $post->saveFile($request->file);

        $post->load('user');

        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return success(__('Post deleted successfully'));
    }
}
