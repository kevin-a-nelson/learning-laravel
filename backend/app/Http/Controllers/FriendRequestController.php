<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendRequestResource;
use App\Models\FriendRequest;
use App\Services\FriendRequestService;
use App\Http\Resources\FriendRequestCollection;
use App\Models\Friendship;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class FriendRequestController extends Controller
{

    protected $friendRequestService;

    public function __construct(FriendRequestService $friendRequestService)
    {
        $this->friendRequestService = $friendRequestService;
    }

    public function index(Request $request)
    {
        $items = $this->friendRequestService->index($request);
        return FriendRequestCollection::make($items)->toArray();
    }

    public function show($id)
    {
        $item = $this->friendRequestService->show($id);
        return new FriendRequestResource($item);
    }

    public function store(Request $request)
    {
        $friendship = $this->friendRequestService->store($request);

        if (!$friendship) {
            return response()->json(["message" => "A reverse friend request was found. Friendship created, and friend request's deleted."]);
        }

        return new FriendRequestResource($friendship);
    }

    public function destroy($id)
    {
        $friendRequest = $this->friendRequestService->destroy($id);
        return new FriendRequestResource($friendRequest);
    }
}
