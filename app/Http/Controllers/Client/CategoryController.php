<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Param;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ParamService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function productsIndex(Category $category): Response
    {
        $categoryChildrenIds = CategoryService::getCategoryChildren($category);

        $params = ParamWithValuesResource::collection(ParamService::indexByCategories($categoryChildrenIds))->resolve();
        $products = Product::byCategories($categoryChildrenIds->pluck('id'))->get();
        $breadcrumbs = CategoryResource::collection(CategoryService::getCategoryParents($category)->reverse())->resolve();
        $resources = ProductResource::collection($products);
        $category = CategoryResource::make($category)->resolve();

        // применяем withRelations к каждому ресурсу
        foreach ($resources as $resource) {
            $resource->withRelations(['images']);
        }

        $products = $resources->resolve();

        return Inertia::render('Client/Category/ProductIndex', compact('category', 'products', 'breadcrumbs', 'params'));
    }
}
