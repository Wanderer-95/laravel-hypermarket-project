<?php

namespace App\Services;

use App\Models\ProductGroup;

class ProductGroupService
{
    public static function store(array $data): ProductGroup
    {
        return ProductGroup::query()->create($data);
    }

    public static function update(ProductGroup $productGroup, array $data): ProductGroup
    {
        $productGroup->update($data);

        return $productGroup->fresh();
    }
}
