<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Models\TemporaryImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    protected static function boot(): void
    {
        parent::boot();

        //TODO Refactor
        static::creating(function (User $user) {
            if (!empty($user->photo_path)) {
                return;
            }

            if ($user->sex === 'не указан') {
                // TODO Images for undefined sex
                return;
            }

            if ($user->sex === 'женский') {
                $all = Storage::disk('images')->allFiles('plugs/avatars/female');
            }

            if ($user->sex === 'мужской') {
                $all = Storage::disk('images')->allFiles('plugs/avatars/male');
            }
            $rand = Arr::random($all);
            $file = File::get(resource_path('images/' . $rand));
            $fileName = time();
            $extension = File::extension(resource_path('images/' . $rand));
            $path = "images/user_photos/$fileName.$extension";
            Storage::put($path, $file);

            $user->photo_path = $path;
        });
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value / 100),
            set: fn ($value) => ($value * 100)
        );
    }

    protected function getAvatarAttribute()
    {
        return "/storage/$this->photo_path";
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
