<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductParent\StoreRequest;
use App\Http\Requests\Admin\ProductParent\UpdateRequest;
use App\Http\Resources\ProductParent\ProductParentResource;
use App\Models\ProductParent;
use App\Services\ProductParentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductParentController extends Controller
{
    public function index(): Response
    {
        $productParents = ProductParent::all();
        $productParents = ProductParentResource::collection($productParents)->resolve();

        return Inertia::render('Admin/ProductParent/Index', compact('productParents'));
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ProductParent/Create');
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $productParent = ProductParentService::store($data);

        return ProductParentResource::make($productParent)->resolve();
    }

    public function show(ProductParent $productParent): Response
    {
        $productParent = ProductParentResource::make($productParent)->resolve();

        return Inertia::render('Admin/ProductParent/Show', compact('productParent'));
    }

    public function edit(ProductParent $productParent): Response
    {
        $productParent = ProductParentResource::make($productParent)->resolve();

        return Inertia::render('Admin/ProductParent/Edit', compact('productParent'));
    }

    public function update(UpdateRequest $request, ProductParent $productParent): array
    {
        $data = $request->validated();
        $productParent = ProductParentService::update($productParent, $data);

        return ProductParentResource::make($productParent)->resolve();
    }

    public function destroy(ProductParent $productParent): JsonResponse
    {
        $productParent->delete();

        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }
}
