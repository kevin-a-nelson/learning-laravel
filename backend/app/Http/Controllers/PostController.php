<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\PostService;

class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function show($id)
    {
        $post = Post::find($id);

        return response()->json([
            "id" => $post->id,
            "title" => $post->title,
            "text" => $post->text,
            "user" => User::where('id', $post->user_id)->first(),
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
            "user" => User::where('id', $post->user_id)->first(),
            "userId" => $post->user_id
        ]);
    }

    public function index(Request $request)
    {
        $posts = $this->postService->index($request);

        return response()->json($posts->toArray());
    }

    public function create(Request $request)
    {
        // dd('test');

        $post = new Post();
        $post->user_id = $request->user_id;
        $post->text = $request->text;
        $post->title = $request->title;

        $post->save();

        return response()->json([
            'message' => 'Post Created Sucess',
            'post' => $post,
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
