<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class FriendshipResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "userOneId" => $this->userOneId,
            "userTwoId" => $this->userTwoId,
            "userOne" => User::where('id', $this->userOneId)->first(),
            "userTwo" => User::where('id', $this->userTwoId)->first()

        ];
    }
}