<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class FriendRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "senderId" => $this->senderId,
            "recipientId" => $this->recipientId,
            "senderUser" => User::where('id', $this->senderId)->first(),
            "recipientUser" => User::where('id', $this->recipientId)->first(),
        ];
    }
}