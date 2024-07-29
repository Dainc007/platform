<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code'
    ];

    //todo separate class
    const AVAILABLE_CURRENCIES = [
      'dollar' => 'USD',
        'pound' => 'GBP',
        'euro' => 'EUR',
        'złoty' => 'PLN'
    ];
}
