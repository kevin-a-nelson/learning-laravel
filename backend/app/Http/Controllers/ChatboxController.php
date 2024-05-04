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
            $chatBoxes = DB::table('chatboxes')->where("userOneId", $userOneId)->where("userTwoId", $userTwoId);

            if (!$chatBoxes->exists()) {
                $chatBoxes = DB::table('chatboxes')->where("userOneId", $userTwoId)->where("userTwoId", $userOneId);
            }
        }

        // dd($chatBoxes->get());

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
        $userOneId = $request->userOneId;
        $userTwoId = $request->userTwoId;

        $duplicateChatbox = DB::table('chatboxes')
            ->where("userOneId", $userOneId)
            ->Where("userTwoId", $userTwoId);

        if ($duplicateChatbox->exists()) {
            return response()->json([
                "message" => "Duplicate chatbox"
            ], 404);
        }

        $reverseDuplicateChatbox = DB::table('chatboxes')
            ->where("userOneId", $userTwoId)
            ->Where("userTwoId", $userOneId);

        if ($reverseDuplicateChatbox->exists()) {
            return response()->json([
                "message" => "Duplicate chatbox"
            ], 404);
        }

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
