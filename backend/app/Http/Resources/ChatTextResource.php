<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;



class ChatTextResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "message" => $this->message,
            "senderId" => $this->senderId,
            "chatboxId" => $this->chatboxId,
            "created_at" => $this->created_at,
        ];
    }
}