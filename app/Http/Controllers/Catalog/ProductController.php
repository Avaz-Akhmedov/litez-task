<?php

namespace App\Http\Controllers\Catalog;

use App\Filters\Catalog\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\FilterProductRequest;
use App\Http\Requests\Catalog\StoreProductRequest;
use App\Http\Requests\Catalog\UpdateProductRequest;
use App\Http\Resources\Catalog\ProductResource;
use App\Models\Catalog\Product;
use App\Services\Catalog\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(FilterProductRequest $request, ProductFilter $filter): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->tap(fn($query) => $filter->apply($query, $request->validated()))
            ->paginate(16);


        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {

        return ProductResource::make($product->load(['category', 'attributes', 'stock']));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {

        $product = $this->productService->create($request->validated());


        return response()->json([
            'success' => true,
            'product' => ProductResource::make($product)
        ], 201);
    }

    public function update(UpdateProductRequest $request, int $productId): JsonResponse
    {

        $product = $this->productService->update($request->validated(),$productId);

        return response()->json([
            'success' => true,
            'product' => ProductResource::make($product)
        ],);
    }
}
