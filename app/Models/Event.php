<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'max_members',
    ];

    protected $with = ['creator', 'orders', 'photos'];

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
