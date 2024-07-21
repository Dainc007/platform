<?php

namespace App\Models;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, BroadcastsEvents;

    protected $fillable = [
        'content',
        'conversation_id',
        'user_id',
    ];

    public function broadcastOn(string $event): array
    {
        return [$this->conversation, $this->user];
    }

    public function conversations()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
