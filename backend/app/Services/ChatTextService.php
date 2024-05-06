<?php

namespace App\Services;

use DB;
use App\Models\ChatText;

use Illuminate\Http\Request;

class ChatTextService
{

    public function index(Request $request)
    {
        $chatTexts = DB::table('chat_texts');

        $chatboxId = $request->chatboxId;

        if ($chatboxId) {
            $chatTexts = $chatTexts->where('chatboxId', $chatboxId);
        }

        return $chatTexts->get();
    }

    public function show($id)
    {
        return ChatText::findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = ChatText::create($request->all());
        return $item;
    }

    public function update(Request $request, $id)
    {
        $item = ChatText::find($id);
        $item->update($request->all());
        return $item;
    }

    public function destroy($id)
    {
        $item = ChatText::find($id);
        $item->delete();
        return $item;
    }
}