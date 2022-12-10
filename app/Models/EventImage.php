<?php

namespace App\Models;

use App\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $fillable = [
        'event_id',
        'user_id',
        'path',
    ];

    public function thumbnailDir(): string
    {
        return 'event_photos';
    }

    protected function thumbnailColumn(): string
    {
        return 'path';
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
