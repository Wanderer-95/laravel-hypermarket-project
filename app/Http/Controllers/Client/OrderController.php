<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderWithCartResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function store(): RedirectResponse
    {
        $order = OrderService::store();
        return to_route('client.orders.transactions.create', $order->id);
    }

    public function createTransaction(Order $order): Response
    {
        $order = OrderWithCartResource::make($order)->resolve();
        return Inertia::render('Client/Order/CreateTransaction', compact('order'));
    }
}
