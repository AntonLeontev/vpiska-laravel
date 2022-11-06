<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'city_code',
        'city_name',
        'email',
        'email_verified_at',
        'password',
        'balance',
        'photo_path',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [];

    protected $attributes = [
        'photo_path' => ''
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function balanceTransfers()
    {
        return $this->hasMany(BalanceTransfer::class);
    }

    public function emailConfirmationHash()
    {
        return $this->hasOne(EmailConfirmationHash::class);
    }
}
