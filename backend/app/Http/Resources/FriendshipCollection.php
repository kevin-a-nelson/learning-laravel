<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use App\Models\User;

class FriendshipCollection extends Collection
{
    public static function make($items = [])
    {
        return new static($items);
    }

    public function toArray()
    {
        $itemCollection = collect($this->items);
        return
            [
                "data" =>
                    $itemCollection->map(function ($item) {
                        return [
                            "id" => $item->id,
                            "userOneId" => $item->userOneId,
                            "userTwoId" => $item->userTwoId,
                            "userOne" => User::where('id', $item->userOneId)->first(),
                            "userTwo" => User::where('id', $item->userTwoId)->first()
                        ];
                    })->toArray()
            ];
    }
}