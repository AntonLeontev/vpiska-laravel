<?php

namespace App\Models;

use App\Traits\Models\HasMoneyAttribute;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use HasMoneyAttribute;

    const ARCHIVED = -1;
    const CANCELED = 0;
    const ACTIVE   = 1;

    protected $fillable = [
        'creator_id',
        'starts_at',
        'ends_at',
        'price',
        'fee',
        'city_fias_id',
        'utc_offset',
        'street_fias_id',
        'building_fias_id',
        'city_name',
        'street',
        'street_type',
        'building',
        'phone',
        'description',
        'max_members',
        'status',
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

    public function getStartDateAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at)->setTimezone($this->utc_offset);
        return $carbon->translatedFormat('j F');
    }

    public function getEndDateAttribute()
    {
        $carbon =  Carbon::parse($this->ends_at)->setTimezone($this->utc_offset);
        return $carbon->translatedFormat('j F');
    }

    public function getFullStartDateAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at)->setTimezone($this->utc_offset);
        return $carbon->translatedFormat('d.m.Y');
    }

    public function getStartTimeAttribute()
    {
        $carbon =  Carbon::parse($this->starts_at)->setTimezone($this->utc_offset);
        return $carbon->translatedFormat('H:i');
    }

    public function getEndTimeAttribute()
    {
        $carbon =  Carbon::parse($this->ends_at)->setTimezone($this->utc_offset);
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

        return $this->orders->last(function ($value) {
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
