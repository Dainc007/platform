<?php

namespace App\Traits\Model;

use App\Models\Pricing;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPricing
{
    public function pricings(): MorphMany
    {
        return $this->morphMany(Pricing::class, 'priceable');
    }
}
