<?php

namespace App\Services;

use DB;
use App\Models\Chatbox;
use Illuminate\Http\Request;

class ChatboxService
{
    public function index(Request $request)
    {
        $chatBoxes = DB::table('chatboxes');

        $userOneId = $request->query("userOneId");
        $userTwoId = $request->query("userTwoId");

        if ($userOneId && $userTwoId) {
            $chatBoxes = $chatBoxes
                ->where("userOneId", $userOneId)->where("userTwoId", $userTwoId)
                ->orWhere("userOneId", $userTwoId)->where("userTwoId", $userOneId);
        }

        return $chatBoxes->get();
    }

    public function store(Request $request)
    {
        $userOneId = $request->userOneId;
        $userTwoId = $request->userTwoId;

        $duplicateChatbox = DB::table('chatboxes')
            ->where("userOneId", $userOneId)
            ->Where("userTwoId", $userTwoId);

        if ($duplicateChatbox->exists()) {
            throw new \Exception("Duplicate chatbox");
        }

        $reverseDuplicateChatbox = DB::table('chatboxes')
            ->where("userOneId", $userTwoId)
            ->Where("userTwoId", $userOneId);

        if ($reverseDuplicateChatbox->exists()) {
            throw new \Exception("Duplicate chatbox");
        }

        $item = Chatbox::create($request->all());

        return $item;
    }

    public function update(Request $request, $id)
    {
        $item = Chatbox::find($id);
        $item->update($request->all());

        return $item;
    }

    public function destroy($id)
    {
        $chatbox = Chatbox::find($id);

        if ($chatbox) {
            $chatbox->delete();
        }

        return $chatbox;
    }
}