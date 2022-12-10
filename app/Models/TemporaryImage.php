<?php

namespace App\Models;

use App\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryImage extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $fillable = [
        'user_id',
        'path'
    ];

    protected function thumbnailDir(): string
    {
        return 'event_photos';
    }

    protected function thumbnailColumn(): string
    {
        return 'path';
    }
}
