<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParamProduct extends Model
{
    protected $table = 'param_product';

    protected $fillable = [
        'value',
        'product_id',
        'param_id',
    ];
}
