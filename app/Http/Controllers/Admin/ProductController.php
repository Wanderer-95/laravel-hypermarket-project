<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::all();
        $products = ProductResource::collection($products)->resolve();

        return Inertia::render('Admin/Product/Index', compact('products'));
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Product/Create');
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $product = ProductService::store($data);

        return ProductResource::make($product)->resolve();
    }

    public function show(Product $product): Response
    {
        $product = ProductResource::make($product)->resolve();

        return Inertia::render('Admin/Product/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        $product = ProductResource::make($product)->resolve();

        return Inertia::render('Admin/Product/Edit', compact('product'));
    }

    public function update(UpdateRequest $request, Product $product): array
    {
        $data = $request->validated();
        $product = ProductService::update($product, $data);

        return ProductResource::make($product)->resolve();
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }
}
