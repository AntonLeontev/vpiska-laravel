<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'starts_at',
        'ends_at',
        'price',
        'fee',
        'city_fias_id',
        'street_fias_id',
        'building_fias_id',
        'city_name',
        'street',
        'street_type',
        'building',
        'phone',
        'description',
        'max_members',
    ];

    protected $with = ['creator', 'images'];

    protected function price(): Attribute
    {
        return $this->moneyAttribute();
    }

    protected function fee(): Attribute
    {
        return $this->moneyAttribute();
    }

    protected function moneyAttribute(): Attribute
    {
        //TODO to separate class
        return Attribute::make(
            get: fn ($value) => ($value / 100),
            set: fn ($value) => ($value * 100)
        );
    }

    public function getStartDateAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at);
        return $carbon->translatedFormat('d F');
    }

    public function getFullStartDateAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at);
        return $carbon->translatedFormat('d.m.Y');
    }

    public function getStartTimeAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at);
        return $carbon->translatedFormat('H:i');
    }

    public function getEndTimeAttribute()
    {
        $carbon =  Carbon::parse($this->ends_at);
        return $carbon->translatedFormat('H:i');
    }

    public function getFullStreetAttribute()
    {
        return "{$this->street_type} {$this->street}";
    }

    public function getFormatedPhoneAttribute(): string
    {
        return sprintf('+%s(%s%s%s)%s%s%s-%s%s-%s%s', ...str_split($this->phone));
    }

    public function currentUserOrder(): Order
    {
        if (!auth()->user()) {
            throw new Exception("Поиск заказов у неавторизованного пользователя", 1);
        }

        return $this->orders->first(function ($value) {
            return $value->customer_id === auth()->user()->id;
        });
    }

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
