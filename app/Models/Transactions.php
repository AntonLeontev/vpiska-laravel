<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'sum',
        'description',
    ];

    public function getDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->translatedFormat('d M y');
    }

    public function getSignedSumAttribute(): string
    {
        $positiveTypes = ['refund', 'refill'];
        $negativeTypes = ['payment', 'withdrawal'];

        if (in_array($this->type, $positiveTypes)) {
            return '+' . (string) $this->sum;
        }

        if (in_array($this->type, $negativeTypes)) {
            return '-' . (string) $this->sum;
        }

        return (string) $this->sum;
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
