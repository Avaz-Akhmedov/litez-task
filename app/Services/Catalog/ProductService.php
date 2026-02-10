<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Product;
use App\Models\Catalog\Stock;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $product = Product::query()->create($data);

            if (!empty($data['attributes'])) {
                $product->attributes()->createMany($data['attributes']);
            }

            Stock::query()->create(['product_id' => $product->id]);

            return $product->load('attributes');
        });
    }

    public function update(array $data, int $productId)
    {
        return DB::transaction(function () use ($data, $productId) {
            $product = Product::query()->findOrFail($productId);

            $product->update($data);

            if (!empty($data['attributes'])) {
                $product->attributes()->delete();
                $product->attributes()->createMany($data['attributes']);
            }

            return $product->load('attributes');
        });
    }
}
