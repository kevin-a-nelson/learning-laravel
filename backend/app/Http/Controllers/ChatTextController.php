<?php

namespace App\Http\Controllers;

use App\Models\ChatText;
use App\Services\ChatTextService;
use App\Http\Resources\ChatTextResource;
use Illuminate\Http\Request;
use App\Http\Resources\ChatTextCollection;

class ChatTextController extends Controller
{
    protected $chatTextService;

    public function __construct(ChatTextService $chatTextService)
    {
        $this->chatTextService = $chatTextService;
    }
    public function index(Request $request)
    {
        $chatTexts = $this->chatTextService->index($request);
        return ChatTextCollection::make($chatTexts)->toArray();
    }

    public function show($id)
    {
        $item = $this->chatTextService->show($id);
        return new ChatTextResource($item);
    }

    public function store(Request $request)
    {
        $item = $this->chatTextService->store($request);
        return new ChatTextResource($item);
    }

    public function update(Request $request, $id)
    {
        $item = $this->chatTextService->update($request, $id);
        return new ChatTextResource($item);
    }

    public function destroy($id)
    {
        $item = $this->chatTextService->destroy($id);
        return new ChatTextResource($item);
    }
}
