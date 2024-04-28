<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostController extends Controller
{

    public function show($id)
    {
        $post = Post::find($id);

        return response()->json([
            "id" => $post->id,
            "title" => $post->title,
            "text" => $post->text,
            "user" => User::where('id', $post->userId)->first(),
            "userId" => $post->userId,
            "created_at" => $post->created_at->format("m/d/Y H:i A"),
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());

        return response()->json([
            "id" => $post->id,
            "title" => $post->title,
            "text" => $post->text,
            "user" => User::where('id', $post->userId)->first(),
            "userId" => $post->userId
        ]);
    }

    public function index(Request $request)
    {
        $posts = Post::orderByDesc("created_at")->get();

        $userIdQuery = $request->query('userId');

        if ($userIdQuery) {
            $posts = $posts->where('userId', $userIdQuery);
        }

        return response()->json(
            $posts->map(function ($post) {
                return [
                    "id" => $post->id,
                    "title" => $post->title,
                    "text" => $post->text,
                    "user" => User::where('id', $post->userId)->first(),
                    "userId" => $post->userId,
                    "created_at" => $post->created_at->format("m/d/Y H:i A"),
                ];
            })->toArray()
        );
    }

    public function create(Request $request)
    {
        $post = new Post();
        $post->userId = $request->userId;
        $post->text = $request->text;
        $post->title = $request->title;
        $post->save();

        return response()->json([
            'message' => 'Post Created Sucess',
            'code' => 200
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'message' => 'Post Deleted',
            'code' => 200
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
