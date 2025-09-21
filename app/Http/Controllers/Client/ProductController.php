<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductWithGroupedParamResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::with('images')->whereNull('parent_id')->get();

        $resources = ProductResource::collection($products);

        // применяем withRelations к каждому ресурсу
        foreach ($resources as $resource) {
            $resource->withRelations(['images']);
        }

        $products = $resources->resolve();

        return Inertia::render('Client/Product/Index', compact('products'));
    }

    public function show(Product $product): Response
    {
        $product->load('images');
        $breadcrumbs = CategoryResource::collection(
            CategoryService::getCategoryParents($product->category)
                ->reverse()
                ->push($product->category)
        )->resolve();

        $resource = ProductWithGroupedParamResource::make($product);

        $resource->withRelations(['images']);

        $product = $resource->resolve();

        return Inertia::render('Client/Product/Show', compact('product', 'breadcrumbs'));
    }
}
