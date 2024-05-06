<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\PostService;
use App\Http\Resources\PostResource;

class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->index($request);
        return PostCollection::make($posts)->toArray();
    }

    public function show($id)
    {
        $post = $this->postService->show($id);
        return PostResource::make($post);
    }

    public function update(Request $request, $id)
    {
        $post = $this->postService->update($request, $id);
        return PostResource::make($post);
    }

    public function create(Request $request)
    {
        $post = $this->postService->create($request);
        return PostResource::make($post);
    }

    public function destroy($id)
    {
        $post = $this->postService->destroy($id);
        return PostResource::make($post);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
