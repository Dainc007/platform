<?php

namespace App\Traits\Model;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddress
{
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
