<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;

class ProductService
{
    public static function store(array $data): Product
    {
        return Product::query()->create(Arr::get($data, 'product'));
    }

    public static function update(Product $product, array $data): Product
    {
        $product->update(Arr::get($data, 'product'));

        return $product->fresh();
    }
}
