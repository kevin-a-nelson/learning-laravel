<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class ChatboxCollection extends Collection
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
                    "userOneId" => $item->userOneId,
                    "userTwoId" => $item->userTwoId,
                ];
            })->toArray()
        ];
    }
}