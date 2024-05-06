<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Support\Collection;

class FriendRequestCollection extends Collection
{
    public static function make($items = [])
    {
        return new static($items);
    }

    public function toArray()
    {
        $itemCollection = collect($this->items);

        return [
            "data" =>
                $itemCollection->map(function ($item) {
                    return [
                        "id" => $item->id,
                        "senderId" => $item->senderId,
                        "recipientId" => $item->recipientId,
                        "senderUser" => User::where('id', $item->senderId)->first(),
                        "recipientUser" => User::where('id', $item->recipientId)->first(),
                    ];
                })
        ];
    }
}