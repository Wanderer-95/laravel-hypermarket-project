<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $table = 'product_user_cards';

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'qty',
        'status',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getCartProductIdAttribute(): int
    {
        $this->load('product');
        return $this->product->id;
    }

    public function getProductTitleAttribute(): string
    {
        return $this->product->title;
    }

    public function getProductImageUrlAttribute(): string
    {
        return $this->product->preview_url ?? '';
    }

    public function getTotalSumAttribute(): float
    {
        $this->load('product');
        return $this->qty * $this->product->price;
    }
}
