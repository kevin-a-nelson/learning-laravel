<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class PostCollection extends Collection
{
    public static function make($items = [])
    {
        return new static($items);
    }

    public function toArray()
    {
        $itemCollection = collect($this->items);
        return $itemCollection->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'text' => $item->text,
                'user' => $item->user, // Assuming 'user' is a relationship in item model
                'userId' => $item->user_id,
                'created_at' => $item->created_at->format('m/d/Y H:i A'),
            ];
        })->toArray();
    }
}