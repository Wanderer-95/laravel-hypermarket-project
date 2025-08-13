<?php

namespace App\Models;

use App\Enums\Param\ParamTypeFilterEnum;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $fillable = [
        'title',
        'filter_type',
    ];

    protected function getFilterTypeTitleAttribute(): string
    {
        return ParamTypeFilterEnum::from($this->filter_type)->name;
    }
}
