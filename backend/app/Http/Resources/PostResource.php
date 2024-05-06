<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'user' => $this->user, // Assuming 'user' is a relationship in item model
            'userId' => $this->user_id,
            'created_at' => $this->created_at->format('m/d/Y H:i A'),
        ];
    }
}