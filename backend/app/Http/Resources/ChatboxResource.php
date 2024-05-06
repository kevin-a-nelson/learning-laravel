<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatboxResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "userOneId" => $this->userOneId,
            "userTwoId" => $this->userTwoId,
        ];
    }
}