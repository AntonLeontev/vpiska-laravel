<?php

namespace App\Models;

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
        'city',
        'city_name',
        'street',
        'building',
        'phone',
        'description',
        'max_members',
    ];

    protected $with = ['creator', 'orders', 'photos'];

    protected function price(): Attribute
    {
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

    public function getStartTimeAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at);
        return $carbon->translatedFormat('H:i');
    }

    public function currentUserOrder(): Order|bool
    {
        if (auth()->user()) {
            return false;
        }

        return $this->orders->first(function ($value, $key) {
            if ($value->customer_id === auth()->user()->id) {
                return true;
            }
            return false;
        });
    }

    public function photos()
    {
        return $this->hasMany(EventPhoto::class);
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
