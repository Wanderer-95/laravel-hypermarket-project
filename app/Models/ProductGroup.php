<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductGroup extends Model
{
    protected $fillable = [
        'title'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_group_id', 'id')->whereNotNull('parent_id');
    }
}
