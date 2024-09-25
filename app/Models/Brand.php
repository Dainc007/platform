<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
       'id', 'name',
    ];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function temporaryProducts(): HasMany
    {
        return $this->hasMany(TemporaryProduct::class);
    }
}
