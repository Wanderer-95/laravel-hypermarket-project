<?php

namespace App\Services;

use App\Models\Param;
use App\Models\ParamProduct;
use App\Models\Product;
use Illuminate\Support\Collection;

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

    public static function indexByCategories(Collection $collection): Collection
    {
        $arr = collect();

        $collection->pluck('paramProducts')->each(function (Collection $coll) use ($arr) {
            $coll->each(function (ParamProduct $paramProduct) use ($arr) {
                $arr->push($paramProduct);
            });
        });

        $params = Param::query()->whereIn('id', $arr->pluck('param_id'))->get();
        $arr = $arr->groupBy('param_id');

        $params->each(function (Param $param) use ($arr) {
            $param->param_values = $arr[$param->id]->unique('value')->sortBy('value')->pluck('value')->toArray();
        });

        return $params;
    }
}
