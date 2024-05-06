<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbox;
use Illuminate\Support\Collection;
use App\Services\ChatboxService;
use App\Http\Resources\ChatboxCollection;
use App\Http\Resources\ChatboxResource;
use DB;

class ChatboxController extends Controller
{
    protected $chatboxService;

    public function __construct(ChatboxService $chatboxService)
    {
        $this->chatboxService = $chatboxService;
    }
    public function index(Request $request)
    {
        $chatBoxes = $this->chatboxService->index($request);
        return ChatboxCollection::make($chatBoxes)->toArray();
    }

    public function show($id)
    {
        $item = Chatbox::find($id);
        return new ChatboxResource($item);
    }

    public function store(Request $request)
    {
        $chatbox = $this->chatboxService->store($request);
        return new ChatboxResource($chatbox);
    }

    public function update(Request $request, $id)
    {
        $item = $this->chatboxService->update($request, $id);
        return new ChatboxResource($item);
    }

    public function destroy($id)
    {
        $chatbox = $this->chatboxService->destroy($id);
        return new ChatboxResource($chatbox);
    }
}
