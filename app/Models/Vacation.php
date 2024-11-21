<?php

namespace App\Models;

use App\Traits\Model\BelongsToUser;
use App\Traits\Model\HasNotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vacation extends Model
{
    use HasFactory, Notifiable, BelongsToUser, HasNotes;

    public const AVAILABLE_STATUSES = [
        'pending', 'accepted', 'rejected', 'cancelled'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_at',
        'end_at',
        'status',
        'message',
        'hours_worked',
    ];

    protected $casts = [
        'start_at' => 'date:d-m-y',
        'end_at' => 'date:d-m-y',
    ];
}
