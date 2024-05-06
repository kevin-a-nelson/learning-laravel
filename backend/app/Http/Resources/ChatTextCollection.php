<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class ChatTextCollection extends Collection
{
    public static function make($items = [])
    {
        return new static($items);
    }

    public function toArray()
    {
        $itemCollection = collect($this->items);

        return [
            "data" => $itemCollection->map(function ($item) {
                return [
                    "id" => $item->id,
                    "message" => $item->message,
                    "senderId" => $item->senderId,
                    "chatboxId" => $item->chatboxId,
                    "created_at" => $item->created_at,
                ];
            })->toArray(),
        ];
    }
}