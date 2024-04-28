<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::orderByDesc('created_at')->get();

        $postIdQuery = $request->query('postId');

        if ($postIdQuery) {
            $comments = $comments->where('postId', $postIdQuery);
        }

        return response()->json(
            $comments->map(function ($comment) {
                return [
                    "id" => $comment->id,
                    "text" => $comment->text,
                    "user" => User::where('id', $comment->userId)->first(),
                    "userId" => $comment->userId,
                    "postId" => $comment->postId,
                    "created_at" => $comment->created_at->format('m/d/Y H:i A'),
                ];
            })->toArray()
        );
    }

    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->userId = $request->userId;
        $comment->postId = $request->postId;
        $comment->save();

        return $comment;
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $comment->update($request->all());

        return response()->json([
            "id" => $comment->id,
            "text" => $comment->text,
            "user" => User::where('id', $comment->userId)->first(),
            "userId" => $comment->userId,
            "postId" => $comment->postId,
            "created_at" => $comment->created_at->format('m/d/Y H:i A'),
        ]);

    }

    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();
    }
}
