<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

// use ILl

class FriendRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipientId',
        'senderId',
        'accepted',
        'message',
    ];

    public function rules(): array
    {
        return [
            'recipientId' => [
                'required',
                'unique:expenses,date',
                Rule::unique('expenses', 'date')->where('user_id', $this->input('user_id')),
            ],
        ];
    }

    // Validator::make($data, [
    //     'data.ip' => [
    //         'required',
    //         Rule::unique('servers')->where(function ($query) use($ip,$hostname) {
    //             return $query->where('ip', $ip)
    //             ->where('hostname', $hostname);
    //         }),
    //     ],
    // ],
}
