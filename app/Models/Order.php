<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use App\Services\Cypix\CypixService;
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
        'show',
    ];

    protected $with = [
        'customer',
        'event'
    ];

    protected $casts = [
        'show' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->code = (string) rand(100000, 999999);
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

    public function isPaid(): bool
    {
        if (is_null($this->payment_id)) {
            return false;
        }

        if ($this->payment_id === 'balance') {
            return true;
        }

        return app(CypixService::class)->transactionIsPaid($this->payment_id);
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
