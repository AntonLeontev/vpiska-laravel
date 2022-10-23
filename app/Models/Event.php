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

    public function photos()
    {
        $this->hasMany(EventPhoto::class);
    }

    public function orders()
    {
        $this->hasMany(Order::class);
    }
}
