<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier',
        'code',
        'price',
        'brand',
        'currency'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d',
    ];

}
