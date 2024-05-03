<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chatbox;

use DB;

class ChatboxController extends Controller
{
    public function index(Request $request)
    {
        $chatBoxes = DB::table('chatboxes');

        $userOneId = $request->query("userOneId");
        $userTwoId = $request->query("userTwoId");

        if ($userOneId && $userTwoId) {
            $chatBoxes->where($userOneId);
        }

        if ($userTwoId) {
            $chatBoxes->where($userTwoId);
        }

        $chatBoxes = $chatBoxes->get();

        return response()->json($chatBoxes);
    }

    public function show($id)
    {
        $item = Chatbox::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = Chatbox::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Chatbox::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        $chatbox = Chatbox::find($id);

        if ($chatbox) {
            $chatbox->delete();
        }

        return response()->json(["message" => "Chatbox deleted",], 200);
    }
}
