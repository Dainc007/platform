<?php

namespace App\Models;

use App\Traits\Model\BelongsToUser;
use App\Traits\Model\HasNotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasNotes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'phone_number',
    ];
}
