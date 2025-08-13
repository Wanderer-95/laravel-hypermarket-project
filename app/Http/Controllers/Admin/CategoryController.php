<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();

        return Inertia::render('Admin/Category/Index', compact('categories'));
    }

    public function create(): Response
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();
        return Inertia::render('Admin/Category/Create', compact('categories'));
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $category = CategoryService::store($data);
        return CategoryResource::make($category)->resolve();
    }

    public function show(Category $category): Response
    {
        $category = CategoryResource::make($category)->resolve();

        return Inertia::render('Admin/Category/Show', compact('category'));
    }

    public function edit(Category $category): Response
    {
        $categories = Category::all()->except($category->id);
        $category = CategoryResource::make($category)->resolve();
        $categories = CategoryResource::collection($categories)->resolve();
        return Inertia::render('Admin/Category/Edit', compact('category', 'categories'));
    }

    public function update(UpdateRequest $request, Category $category): array
    {
        $data = $request->validated();
        $category = CategoryService::update($category, $data);

        return CategoryResource::make($category)->resolve();
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }
}
