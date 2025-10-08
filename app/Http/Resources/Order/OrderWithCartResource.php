<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Cart\CartWithProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderWithCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'carts' => CartWithProductResource::collection($this->carts)->resolve()
        ];
    }
}
