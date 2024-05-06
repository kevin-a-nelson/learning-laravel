<?php

namespace App\Services;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentService
{

    public function index(Request $request)
    {
        $comments = Comment::orderByDesc('created_at');

        $postIdQuery = $request->query('postId');

        if ($postIdQuery) {
            $comments = $comments->where('postId', $postIdQuery);
        }

        return $comments->get();
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

    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $comment->update($request->all());

        return $comment;
    }

    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return $comment;
    }
}
