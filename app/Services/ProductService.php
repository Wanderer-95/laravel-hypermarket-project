<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static function store(array $data): Product
    {
        try {
            DB::beginTransaction();
            $product = Product::query()->create(Arr::get($data, 'product'));
            ProductService::storeImages($product, Arr::get($data, 'images'));
            self::storeProductParam($product, Arr::get($data, 'params'));
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, 'Store transaction failed');
        }
    }

    public static function update(Product $product, array $data): Product
    {
        try {
            DB::beginTransaction();
            ProductService::storeImages($product, Arr::get($data, 'images'));
            ProductService::syncBatchParams($product, $data);
            $product->update(Arr::get($data, 'product'));
            DB::commit();
            return $product->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, 'Updated transaction failed');
        }
    }

    public static function storeProductParam(Product $product, ?array $data = null): void
    {
        if (isset($data)) {
            foreach ($data as $param) {
                $product->params()->attach($param['param_id'], [
                    'value' => $param['value']
                ]);
            }
        }
    }

    public static function syncBatchParams(Product $product, ?array $data = null): void
    {
        if (isset($data['params'])) {
            $product->params()->detach();
            ParamService::attachBatchParams($product, $data['params']);
        }
    }

    private static function storeImages(Product $product, ?array $images = null): void
    {
        if (isset($images)) {
            ImageService::storeBatch($product, $images);
        }
    }

    public static function indexByCategories(Collection $collection, array $data)
    {
        $products = Product::byCategories($collection->pluck('id'));

        if (isset($data['filters']['integer']['from']))
        {
            $products->whereHas('paramProducts', function ($query) use ($data)
            {
                foreach ($data['filters']['integer']['from'] as $key => $value)
                {
                    $query->where('param_id', $key)->whereRaw('CAST(value as INT) >= ?', $value);
                }
            });
        }

        if (isset($data['filters']['integer']['to']))
        {
            $products->whereHas('paramProducts', function ($query) use ($data)
            {
                foreach ($data['filters']['integer']['to'] as $key => $value)
                {
                    $query->where('param_id', $key)->whereRaw('CAST(value as INT) <= ?', $value);
                }
            });
        }

        if (isset($data['filters']['checkbox']))
        {
            $products->whereHas('paramProducts', function ($query) use ($data)
            {
                foreach ($data['filters']['checkbox'] as $key => $value)
                {
                    $query->where('param_id', $key)->whereIn('value', $value);
                }
            });
        }

        if (isset($data['filters']['select']))
        {
            $products->whereHas('paramProducts', function ($query) use ($data)
            {
                foreach ($data['filters']['select'] as $key => $value)
                {
                    $query->where('param_id', $key)->where('value', $value);
                }
            });
        }

        return $products->distinct('parent_id')->get();
    }
}
