<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CategoryService
{
    public static function store(array $data): Category
    {
        return Category::query()->create($data);
    }

    public static function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

//    public static function getCategoryChildren(Category $category): Collection
//    {
//        // Загружаем всё дерево сразу, включая нужные связи
//        $allCategories = Category::with(['children', 'paramProducts'])->get();
//
//        return self::collectDescendants($category, $allCategories);
//    }
//
//    protected static function collectDescendants(Category $category, Collection $allCategories, Collection $result = null): Collection
//    {
//        $result = $result ?? collect();
//
//        // Добавляем текущую категорию
//        $result->push($category);
//
//        // Ищем детей текущей категории
//        $children = $allCategories->where('parent_id', $category->id);
//
//        foreach ($children as $child) {
//            self::collectDescendants($child, $allCategories, $result);
//        }
//
//        return $result;
//    }

    public static function getCategoryChildren(Category $category): Collection
    {
        $collection = collect();

        $category->load('children');
        foreach ($category->children as $categoryChild) {
            $categoryChild->load('paramProducts');
            $collection = $collection->merge(self::getCategoryChildren($categoryChild));
        }

        $collection->push($category);

        return $collection;
    }

    public static function getCategoryParents(Category $category): Collection
    {
        $collection = collect();

        if ($category->parent_id)
        {
            $categoryParent = Category::query()->find($category->parent_id);
            $collection->push($categoryParent);
            $collection = $collection->merge(self::getCategoryParents($categoryParent));
        }

        return $collection;
    }
}
