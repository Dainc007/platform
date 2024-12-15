<?php

namespace App\Models;

use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([FileObserver::class])]
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
