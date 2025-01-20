<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'is_enabled', 'disabled_hours'
    ];
}
