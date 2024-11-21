<?php

namespace App\Models;

use App\Traits\Model\HasNotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory, HasNotes;

    protected $fillable = [
        'start_date',
        'end_date',
        'user_id',
        'hours_worked',
        'status'
    ];

    const STARTING_HOUR = 8;
    const FINISHING_HOUR = 16;
    const DURATION = 20;

    public const AVAILABLE_STATUSES = [
        'free', 'booked', 'cancelled', 'done'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
