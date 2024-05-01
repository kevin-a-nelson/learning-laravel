<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class FriendRequestController extends Controller
{
    public function index(Request $request)
    {
        $userIdQuery = $request->query('userId');

        $items = DB::table('friend_requests');

        if ($userIdQuery) {
            $items = DB::table('friend_requests')
                ->where('senderId', $userIdQuery)
                ->orWhere('recipientId', $userIdQuery)
                ->get();
        }

        return response()->json(
            $items->map(function ($item) {
                return [
                    "id" => $item->id,
                    "senderId" => $item->senderId,
                    "recipientId" => $item->recipientId,
                    "senderUser" => User::where('id', $item->senderId)->first(),
                    "recipientUser" => User::where('id', $item->recipientId)->first(),
                ];
            })
        );
    }

    public function show($id)
    {
        $item = FriendRequest::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $duplicateFriendRequest = DB::table('friend_requests')
            ->where("senderId", $request->senderId)
            ->where("recipientId", $request->recipientId)
            ->get();

        if (!$duplicateFriendRequest->isEmpty()) {
            return response()->json([
                "message" => "Duplicate Friend Request",
            ], 404);
        }

        $item = FriendRequest::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = FriendRequest::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        FriendRequest::destroy($id);
        return response()->json(null, 204);
    }
}
