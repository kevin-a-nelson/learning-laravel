<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function index(Request $request)
    {
        return Friendship::all();
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
