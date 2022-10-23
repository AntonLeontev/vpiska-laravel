<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'author_id',
        'user_id',
        'text',
    ];

    public function author()
    {
        $this->belongsTo(User::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
