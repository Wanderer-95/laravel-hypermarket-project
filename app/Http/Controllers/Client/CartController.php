<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Cart\StoreRequest;
use App\Http\Requests\Client\Cart\UpdateRequest;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Cart\CartWithProductAndTotalSumResource;
use App\Http\Resources\Cart\CartWithProductResource;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $carts = CartWithProductResource::collection(auth()->user()->carts)->resolve();
        return Inertia::render('Client/Cart/Index', compact('carts'));
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $cart = CartService::store($data);
        return CartWithProductAndTotalSumResource::make($cart)->resolve();
    }

    public function update(Cart $cart, UpdateRequest $request): array
    {
        $data = $request->validated();
        $cart = CartService::update($cart, $data);
        return CartWithProductAndTotalSumResource::make($cart)->resolve();
    }

    public function destroy(Cart $cart): JsonResponse
    {
        $cart->delete();
        return response()->json(['message' => 'Successfully removed.'], \Illuminate\Http\Response::HTTP_OK);
    }
}
