<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'city_code',
        'city_name',
        'email',
        'email_confirmed',
        'password',
        'balance',
        'photo_path',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_confirmed' => 'boolean',
    ];

    protected $attributes = [
        'photo_path' => ''
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function event()
    {
        $this->hasMany(Event::class);
    }

    public function order()
    {
        $this->hasMany(Order::class);
    }
}
