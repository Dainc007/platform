<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'price',
        'currency_id',
        'contractor_id',
        'file_id'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }


}
