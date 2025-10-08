<?php

namespace App\Services;

use App\Models\Cart;

class CartService
{
    public static function store(array $data): Cart
    {
        return auth()->user()->carts()->create($data);
    }

    public static function update(Cart $cart, array $data): Cart
    {
        $cart->update($data);
        return $cart->fresh();
    }
}
