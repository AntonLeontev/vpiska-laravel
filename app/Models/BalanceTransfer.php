<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalanceTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'sum',
        'description',
    ];

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i');
    }

    protected function sum(): Attribute
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
