<?php

namespace App\Mappers\Client;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ParamService;
use App\Services\ProductService;

class CategoryMapper
{
    public static function productsIndex(Category $category, array $data)
    {
        $categoryChildrenIds = CategoryService::getCategoryChildren($category);
        $resources = ProductResource::collection(ProductService::indexByCategories($categoryChildrenIds, $data));

        foreach ($resources as $resource) {
            $resource->withRelations(['images']);
        }

        return [
            'categoryChildren' => CategoryResource::collection($category->children)->resolve(),
            'products' => $resources->resolve(),
            'params' => ParamWithValuesResource::collection(ParamService::indexByCategories($categoryChildrenIds))->resolve(),
            'breadcrumbs' => CategoryResource::collection(CategoryService::getCategoryParents($category)->reverse())->resolve(),
            'category' => CategoryResource::make($category)->resolve(),
        ];
    }

    public static function productsIndexAsJson(Category $category, array $data): array
    {
        $categoryChildrenIds = CategoryService::getCategoryChildren($category);
        $resources = ProductResource::collection(ProductService::indexByCategories($categoryChildrenIds, $data));

        // применяем withRelations к каждому ресурсу

        foreach ($resources as $resource) {
            $resource->withRelations(['images']);
        }

        return $resources->resolve();
    }
}
