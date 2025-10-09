<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['seen'];

    public function scopeBetweenUsers($query, $user1, $user2)
    {
        return $query->where(function($q) use ($user1, $user2) {
            $q->where([
                'from_id' => $user1,
                'to_id' => $user2
            ])->orWhere([
                'from_id' => $user2,
                'to_id' => $user1
            ]);
        });
    }
}
