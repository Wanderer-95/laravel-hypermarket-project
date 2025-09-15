<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ParamService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function productsIndex(Category $category, ProductIndexRequest $request): Response|Collection|array
    {
        $data = $request->validated();

        $categoryChildrenIds = CategoryService::getCategoryChildren($category);
        $resources = ProductResource::collection(ProductService::indexByCategories($categoryChildrenIds, $data));

        // применяем withRelations к каждому ресурсу

        foreach ($resources as $resource) {
            $resource->withRelations(['images']);
        }

        $products = $resources->resolve();

        if ($request->wantsJson())
        {
            return $products;
        }

        $params = ParamWithValuesResource::collection(ParamService::indexByCategories($categoryChildrenIds))->resolve();
        $breadcrumbs = CategoryResource::collection(CategoryService::getCategoryParents($category)->reverse())->resolve();
        $category = CategoryResource::make($category)->resolve();

        return Inertia::render('Client/Category/ProductIndex', compact('category', 'products', 'breadcrumbs', 'params'));
    }
}
