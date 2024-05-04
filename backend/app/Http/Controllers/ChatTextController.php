<?php

namespace App\Http\Controllers;

use App\Models\ChatText;
use DB;
use Illuminate\Http\Request;

class ChatTextController extends Controller
{
    public function index(Request $request)
    {
        $chatTexts = DB::table('chat_texts');

        $chatboxId = $request->chatboxId;

        if ($chatboxId) {
            $chatTexts = $chatTexts->where('chatboxId', $chatboxId);
        }

        $chatTexts = $chatTexts->get();

        return response()->json($chatTexts, 201);
    }

    public function show($id)
    {
        $item = ChatText::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = ChatText::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = ChatText::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        $item = ChatText::find($id);
        $item->delete();
        return response()->json(["message" => "Text is deleted"], 204);
    }
}
