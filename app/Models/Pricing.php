<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'distance_limit', 'price_without_tax', 'price_with_tax', 'tax_rate', 'tax', 'currency_id', 'priceable_type', 'priceable_id',
    ];

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function setPriceAttribute($value): void
    {
        $this->setAttributeInSubunits('price', $value);
    }

    public function setPriceWithTaxAttribute($value): void
    {
        $this->setAttributeInSubunits('price_with_tax', $value);
    }

    public function setPriceWithoutTaxAttribute($value): void
    {
        $this->setAttributeInSubunits('price_without_tax', $value);
    }

    public function setTaxAttribute($value): void
    {
        $this->setAttributeInSubunits('tax', $value);
    }

    public function getPriceAttribute($value): float|int
    {
        return $this->getAttributeInUnits($value);
    }

    public function getPriceWithTaxAttribute($value): float|int
    {
        return $this->getAttributeInUnits($value);
    }

    public function getPriceWithoutTaxAttribute($value): float|int
    {
        return $this->getAttributeInUnits($value);
    }

    public function getTaxAttribute($value): float|int
    {
        return $this->getAttributeInUnits($value);
    }

    private function setAttributeInSubunits($key, $value): void
    {
        $this->attributes[$key] = $value * 100;
    }

    private function getAttributeInUnits($value): float|int
    {
        return $value / 100;
    }
}
