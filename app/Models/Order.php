<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function customer()
    {
        $this->belongsTo(User::class);
    }

    public function event()
    {
        $this->belongsTo(Event::class);
    }
}
