<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'files'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
