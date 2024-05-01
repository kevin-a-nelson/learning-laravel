<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function index()
    {
        $items = FriendRequest::all();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = FriendRequest::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
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
