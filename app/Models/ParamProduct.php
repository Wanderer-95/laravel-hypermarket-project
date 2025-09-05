<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParamProduct extends Model
{
    protected $fillable = [
        'value',
        'product_id',
        'param_id',
    ];
}
