<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;

class PostService
{
    public function index(Request $request)
    {
        $posts = Post::orderByDesc('created_at');

        $userIdQuery = $request->query('user_id');

        if ($userIdQuery) {
            $posts->where('user_id', $userIdQuery);
        }

        return $posts->get();
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return $post;
    }

    public function create(Request $request)
    {
        $post = new Post();
        $post->user_id = $request->user_id;
        $post->text = $request->text;
        $post->title = $request->title;
        $post->save();
        return $post;
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return $post;
    }
}