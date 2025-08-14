<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_group_id',
        'title',
        'description',
        'content',
        'price',
        'old_price',
        'qty',
    ];
}
