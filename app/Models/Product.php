<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'code',
        'price',
        'brand',
        'currency_id'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


}
