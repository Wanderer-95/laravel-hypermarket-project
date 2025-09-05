<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Param;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
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

        return Inertia::render('Admin/Product/Index', compact('products'));
    }

    public function create(): Response
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();
        return Inertia::render('Admin/Product/Create', compact('categories', 'productGroups', 'params'));
    }

    public function createChild(Product $product): Response
    {
        $product->load(['params', 'images']);
        $product = ProductResource::make($product)->withRelations(['images', 'params'])->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();
        return Inertia::render('Admin/Product/CreateChild', compact('categories', 'productGroups', 'params', 'product'));
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $product = ProductService::store($data);

        return ProductResource::make($product)->resolve();
    }

    public function show(Product $product): Response
    {
        $product = $this->loadImages($product);
        return Inertia::render('Admin/Product/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        $product->load(['params', 'images']);
        $product = ProductResource::make($product)->withRelations(['images', 'params'])->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();
        return Inertia::render('Admin/Product/Edit', compact('product', 'categories', 'productGroups', 'params'));
    }

    public function update(UpdateRequest $request, Product $product): array
    {
        $data = $request->validated();
        $product = ProductService::update($product, $data);
        return $this->loadImages($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }

    public function productImage(Image $image): JsonResponse
    {
        $image->delete();
        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }

    private function loadImages(Product $product): array
    {
        $product->load('images');
        return ProductResource::make($product)->withRelations(['images'])->resolve();
    }
}
