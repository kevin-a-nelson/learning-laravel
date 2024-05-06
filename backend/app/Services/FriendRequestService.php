<?php

namespace App\Services;

use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use DB;

class FriendRequestService
{
    public function index(Request $request)
    {
        $userIdQuery = $request->query('userId');

        $items = DB::table('friend_requests');

        if ($userIdQuery) {
            $items = $items
                ->where('senderId', $userIdQuery)
                ->orWhere('recipientId', $userIdQuery);
        }

        return $items->get();
    }

    public function show($id)
    {
        return FriendRequest::findOrFail($id);
    }

    public function store(Request $request)
    {
        $duplicateFriendRequest = DB::table('friend_requests')
            ->where("senderId", $request->senderId)
            ->where("recipientId", $request->recipientId)
            ->get();

        if (!$duplicateFriendRequest->isEmpty()) {
            throw new \Exception("Duplicate Friend Request");
        }

        $reverseFriendRequest = DB::table('friend_requests')
            ->where("senderId", $request->recipientId)
            ->where("recipientId", $request->senderId)
            ->get();

        if (!$reverseFriendRequest->isEmpty()) {
            $friendship = Friendship::create([
                'userOneId' => $request->senderId,
                'userTwoId' => $request->recipientId,
            ]);

            FriendRequest::destroy($reverseFriendRequest[0]->id);
            return null;
        }

        $friendRequest = FriendRequest::create($request->all());
        return $friendRequest;
    }

    public function destroy($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        FriendRequest::destroy($id);
        return $friendRequest;
    }
}

