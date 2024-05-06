<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;

class FriendshipService
{
    public function index(Request $request)
    {
        $friendships = DB::table('friendships');

        $userIdQuery = $request->query('userId');

        if ($userIdQuery) {
            $friendships = $friendships->where("userOneId", $userIdQuery)->orWhere("userTwoId", $userIdQuery);
        }

        return $friendships;
    }
}

class FriendshipCollection extends Collection
{
    public static function make($items = [])
    {
        return new static($items);
    }

    public function toArray()
    {
        $itemCollection = collect($this->items);
        return
            [
                "data" =>
                    $itemCollection->map(function ($item) {
                        return [
                            "id" => $item->id,
                            "userOneId" => $item->userOneId,
                            "userTwoId" => $item->userTwoId,
                            "userOne" => User::where('id', $item->userOneId)->first(),
                            "userTwo" => User::where('id', $item->userTwoId)->first()
                        ];
                    })->toArray()
            ];
    }
}

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
        return FriendshipCollection::make($friendships->get())->toArray();
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
        return response()->json([], 204);
    }

}
