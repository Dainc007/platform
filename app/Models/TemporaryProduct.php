<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'price',
        'currency_id',
        'file_id',
        'brand_id',
        'quantity',
    ];
}
