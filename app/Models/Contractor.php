<?php

namespace App\Models;

use App\Inerfaces\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model implements Fileable
{
    use HasFactory;

    protected $fillable = [
        'name', 'files'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d m:i',
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
