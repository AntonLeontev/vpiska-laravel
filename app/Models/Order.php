<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'customer_id',
        'payment_id',
        'status',
        'code',
    ];

    protected $with = [
        'customer',
        'event'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->code = Str::of(Hash::make(rand(0, 50000)))->limit(5, '');
        });
    }

    public function getStatusNameAttribute()
    {
        if ($this->status === OrderStatus::Accepted->value) {
            return 'Заявка принята';
        }
        if ($this->status === OrderStatus::Declined->value) {
            return 'Заявка отклонена';
        }
        if ($this->status === OrderStatus::Undefined->value) {
            return 'Заявка на рассмотрении';
        }
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
