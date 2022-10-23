<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direction',
        'sum',
        'description',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
