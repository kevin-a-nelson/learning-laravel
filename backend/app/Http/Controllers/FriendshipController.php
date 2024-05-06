<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendshipResource;
use App\Models\Friendship;
use Illuminate\Http\Request;
use DB;
use App\Services\FriendshipService;
use App\Http\Resources\FriendshipCollection;
use App\Http\Resources\Friend;

class FriendshipController extends Controller
{
    protected $friendshipService;

    public function __construct(FriendshipService $friendshipService)
    {
        $this->friendshipService = $friendshipService;
    }

    public function index(Request $request)
    {
        $friendships = $this->friendshipService->index($request);
        return FriendshipCollection::make($friendships)->toArray();
    }

    public function show($id)
    {
        $item = $this->friendshipService->show($id);
        return new FriendshipResource($item);
    }

    public function store(Request $request)
    {
        $friendship = $this->friendshipService->store($request);
        return new FriendshipResource($friendship);
    }

    public function update(Request $request, $id)
    {
        $friendship = $this->friendshipService->update($request, $id);
        return new FriendshipResource($friendship);
    }

    public function destroy($id)
    {
        $friendship = $this->friendshipService->destroy($id);
        return new FriendshipResource($friendship);
    }

}
