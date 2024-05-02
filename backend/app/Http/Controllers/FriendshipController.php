<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class FriendshipController extends Controller
{
    public function index(Request $request)
    {
        $friendships = Friendship::all();

        $userIdQuery = $request->query('userId');

        if ($userIdQuery) {
            $friendships = DB::table('friendships')->where("userOneId", $userIdQuery)->orWhere("userTwoId", $userIdQuery)->get();
        }

        return response()->json(
            $friendships->map(function ($friendship) {
                return [
                    "id" => $friendship->id,
                    "userOneId" => $friendship->userOneId,
                    "userTwoId" => $friendship->userTwoId,
                    "userOne" => User::where('id', $friendship->userOneId)->first(),
                    "userTwo" => User::where('id', $friendship->userTwoId)->first()
                ];
            })->toArray()
        );
    }

    public function show($id)
    {
        $item = Friendship::find($id);
        return response()->json($item);
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
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Friendship::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Friendship::destroy($id);
        return response()->json(null, 204);
    }

}
