<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatText extends Model
{
    use HasFactory;

    protected $fillable = [
        "message",
        "senderId",
        "receiverId",
        "chatboxId",
    ];
}
