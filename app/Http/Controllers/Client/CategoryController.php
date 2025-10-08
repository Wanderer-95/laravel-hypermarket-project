<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Mappers\Client\CategoryMapper;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ParamService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = CategoryResource::collection(Category::query()->whereNull('parent_id')->get())->resolve();

        return Inertia::render('Client/Category/Index', compact('categories'));
    }

    public function productsIndex(Category $category, ProductIndexRequest $request): Response|Collection|array
    {
        $data = $request->validated();

        if ($request->wantsJson())
        {
            return CategoryMapper::productsIndexAsJson($category, $data);
        }

        return Inertia::render('Client/Category/ProductIndex', CategoryMapper::productsIndex($category, $data));
    }
}
