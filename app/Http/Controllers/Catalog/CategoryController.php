<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\StoreCategoryRequest;
use App\Http\Resources\Catalog\CategoryResource;
use App\Models\Catalog\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true)->orderBy('name')->limit(3);
                },
                'children.children' => function ($query) {
                    $query->where('is_active', true)->orderBy('name')->limit(3);
                },
                'children.children.children' => function ($query) {
                    $query->where('is_active', true)->orderBy('name')->limit(3);
                }
            ])
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {

        $category = Category::query()->create($request->validated());

        return response()->json([
            'success' => true,
            'category' => CategoryResource::make($category)
        ], 201);
    }
}
