<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Product extends Model
{
    use HasFactory;

    const AVAILABLE_TYPES = ['standard', 'stock'];

    protected $fillable = [
        'code',
        'price',
        'currency_id',
        'contractor_id',
        'file_id',
        'brand_id',
        'quantity',
        'type'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function brandable(): MorphTo
    {
        return $this->morphTo();
    }


}
