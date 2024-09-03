<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vacation extends Model
{
    use HasFactory, Notifiable;

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
    ];

    protected $casts = [
        'start_at' => 'date:d-m-y',
        'end_at' => 'date:d-m-y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
