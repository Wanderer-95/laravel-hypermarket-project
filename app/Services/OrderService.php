<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function store(): Order
    {
        $order = auth()->user()->orders()->create();
        auth()->user()->carts()->update(['order_id' => $order->id]);
        return $order;
    }
}
