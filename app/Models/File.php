<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'fileable', 'status', 'fileable_id', 'fileable_type'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d m:i',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
