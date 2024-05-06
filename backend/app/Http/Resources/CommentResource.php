<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "text" => $this->text,
            "user" => User::where('id', $this->userId)->first(),
            "userId" => $this->userId,
            "postId" => $this->postId,
            "created_at" => $this->created_at->format('m/d/Y H:i A'),
        ];
    }
}