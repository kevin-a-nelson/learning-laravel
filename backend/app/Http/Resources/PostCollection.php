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
        return $this->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'text' => $post->text,
                'user' => $post->user, // Assuming 'user' is a relationship in Post model
                'userId' => $post->user_id,
                'created_at' => $post->created_at->format('m/d/Y H:i A'),
            ];
        })->toArray();
    }
}