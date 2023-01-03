<?php

namespace App\Models;

use App\Events\UserCreating;
use App\Models\TemporaryImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use App\Traits\Models\HasMoneyAttribute;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasMoneyAttribute;

    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'city_fias_id',
        'city_name',
        'email',
        'email_verified_at',
        'birth_date',
        'password',
        'balance',
        'notifications',
        'photo_path',
        'remember_token',
        'vk_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'photo_path' => ''
    ];

    protected $dispatchesEvents = [
        'creating' => UserCreating::class,
    ];

    protected function balance(): Attribute
    {
        return $this->moneyAttribute();
    }

    protected function getAvatarAttribute()
    {
        if (Storage::exists($this->photo_path)) {
            return "/storage/$this->photo_path";
        }

        return $this->photo_path;
    }

    protected function getSexAttribute($value)
    {
        if ($value === 'male') {
            return 'мужской';
        }

        if ($value === 'female') {
            return 'женский';
        }

        return 'не указан';
    }

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
        return $this->hasMany(Event::class, 'creator_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function balanceTransfers()
    {
        return $this->hasMany(Transactions::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }

    public function tempImages()
    {
        return $this->hasMany(TemporaryImage::class);
    }
}
