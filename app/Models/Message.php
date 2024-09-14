<?php

namespace App\Models;

use App\Traits\Model\BelongsToUser;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, BroadcastsEvents, BelongsToUser;

    protected $fillable = [
        'content',
        'conversation_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'date:d M y m:i',
    ];

    public function broadcastOn(string $event): array
    {
        return [$this->conversation, $this->user];
    }

    public function conversations()
    {
        return $this->belongsTo(Conversation::class);
    }
}
