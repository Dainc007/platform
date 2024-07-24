<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'notable',
    ];

    public function notable()
    {
        return $this->morphTo();
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'notable_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'notable_id');
    }
}
