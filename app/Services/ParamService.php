<?php

namespace App\Services;

use App\Models\Param;
use App\Models\Product;

class ParamService
{
    public static function store(array $data): Param
    {
        return Param::query()->create($data);
    }

    public static function update(Param $param, array $data): Param
    {
        $param->update($data);

        return $param->fresh();
    }

    public static function attachBatchParams(Product $product, array $params): void
    {
        $product->params()->attach($params);
    }
}
