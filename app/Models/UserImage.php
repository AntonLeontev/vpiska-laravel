<?php

namespace App\Models;

use App\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $fillable = [
        'path',
        'user_id',
    ];

    public function thumbnailDir(): string
    {
        return 'user_photos';
    }

    protected function thumbnailColumn(): string
    {
        return 'path';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
