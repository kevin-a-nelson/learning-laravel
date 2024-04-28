<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderByDesc('created_at')->get();

        return response()->json(
            $comments->map(function ($comment) {
                return [
                    "id" => $comment->id,
                    "text" => $comment->text,
                    "user" => User::where('id', $comment->userId)->first(),
                    "userId" => $comment->userId
                ];
            })->toArray()
        );
    }

    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->userId = $request->userId;
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
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
