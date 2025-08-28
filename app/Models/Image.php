<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
        'product_id',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
