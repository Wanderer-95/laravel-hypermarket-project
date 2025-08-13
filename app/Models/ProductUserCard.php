<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUserCard extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'qty',
        'status',
    ];
}
