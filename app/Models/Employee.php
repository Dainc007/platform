<?php

namespace App\Models;

use App\Traits\Model\HasNotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasNotes;

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'phone_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
