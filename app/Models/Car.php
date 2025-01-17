<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'car_type_id'
    ];

    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }
}
