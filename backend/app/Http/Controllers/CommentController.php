<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;
use App\Models\User;
use App\Models\Comment;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $comments = $this->commentService->index($request);

        return CommentCollection::make($comments)->toArray();
    }

    public function create(Request $request)
    {
        $comment = $this->commentService->create($request);

        return new CommentResource($comment);
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
        $comments = $this->commentService->update($request, $id);

        return new CommentResource($comments);
    }

    public function destroy(string $id)
    {
        $comment = $this->commentService->destroy($id);

        return new CommentResource($comment);
    }
}
