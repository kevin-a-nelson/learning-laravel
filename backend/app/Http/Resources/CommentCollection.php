<?php

namespace App\Http\Resources;

use App\Models\User;

use Illuminate\Support\Collection;

class CommentCollection extends Collection
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
                    "text" => $item->text,
                    "user" => User::where('id', $item->userId)->first(),
                    "userId" => $item->userId,
                    "postId" => $item->postId,
                    "created_at" => $item->created_at->format('m/d/Y H:i A'),

                ];
            })->toArray()
        ];
    }
}