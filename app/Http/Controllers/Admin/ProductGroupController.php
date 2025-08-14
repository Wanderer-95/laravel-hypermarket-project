<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGroup\StoreRequest;
use App\Http\Requests\Admin\ProductGroup\UpdateRequest;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\ProductGroup;
use App\Services\ProductGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductGroupController extends Controller
{
    public function index(): Response
    {
        $productGroups = ProductGroup::all();
        $productGroups = ProductGroupResource::collection($productGroups)->resolve();

        return Inertia::render('Admin/ProductGroup/Index', compact('productGroups'));
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ProductGroup/Create');
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::store($data);

        return ProductGroupResource::make($productGroup)->resolve();
    }

    public function show(ProductGroup $productGroup): Response
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return Inertia::render('Admin/ProductGroup/Show', compact('productGroup'));
    }

    public function edit(ProductGroup $productGroup): Response
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return Inertia::render('Admin/ProductGroup/Edit', compact('productGroup'));
    }

    public function update(UpdateRequest $request, ProductGroup $productGroup): array
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::update($productGroup, $data);

        return ProductGroupResource::make($productGroup)->resolve();
    }

    public function destroy(ProductGroup $productGroup): JsonResponse
    {
        $productGroup->delete();

        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }
}
