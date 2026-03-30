<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin()
    {
        return in_array($this->email, ['danielheinze96@gmail.com', 'kontakt@partio.pl']);
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'isAdmin' => $this->isAdmin(),
        ]);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
