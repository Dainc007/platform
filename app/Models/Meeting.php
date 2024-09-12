<?php

namespace App\Models;

use App\Traits\Model\HasNotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory, HasNotes;

    protected $fillable = [
        'start_at',
        'end_at',
        'status',
        'message'
    ];

}
