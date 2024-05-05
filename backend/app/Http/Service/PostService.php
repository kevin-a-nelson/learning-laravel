<?php

namespace App\Services;

use App\Models\Post;
use App\Collections\PostCollection;
use Illuminate\Http\Request;

class PostService
{
    public function index(Request $request)
    {
        $posts = Post::orderByDesc('created_at');

        $userIdQuery = $request->query('userId');

        if ($userIdQuery) {
            $posts->where('user_id', $userIdQuery);
        }

        $posts = $posts->get();

        return PostCollection::make($posts);
    }
}