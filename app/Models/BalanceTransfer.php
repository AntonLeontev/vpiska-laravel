<?php

namespace App\Models;

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
