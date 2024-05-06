<?php

namespace App\Services;

use App\Models\Friendship;
use DB;

use Illuminate\Http\Request;

class FriendshipService
{
    public function index(Request $request)
    {
        $friendships = DB::table('friendships');

        $userIdQuery = $request->query('userId');

        if ($userIdQuery) {
            $friendships = $friendships->where("userOneId", $userIdQuery)->orWhere("userTwoId", $userIdQuery);
        }

        return $friendships->get();
    }

    public function show($id)
    {
        return Friendship::find($id);
    }

    public function store(Request $request)
    {
        $duplicateFriendship = DB::table('friendships')
            ->where("userOneId", $request->userOneId)
            ->where("userTwoId", $request->userTwoId)
            ->get();

        if (!$duplicateFriendship->isEmpty()) {
            return response()->json([
                "message" => "Duplicate Friend Request",
            ], 404);
        }

        $item = Friendship::create($request->all());
        return $item;
    }

    public function update(Request $request, $id)
    {
        $item = Friendship::find($id);
        $item->update($request->all());
        return $item;
    }

    public function destroy($id)
    {
        $friendship = Friendship::find($id);
        Friendship::destroy($id);
        return $friendship;
    }
}