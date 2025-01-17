<?php

namespace App\Models;

use App\Traits\Model\HasAddress;
use App\Traits\Model\HasContacts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, HasAddress, HasContacts;

    protected $fillable = [
        'name', 'min_payload'
    ];
}
