<?php

namespace Database\Seeders;

use App\Models\Catalog\Product;
use App\Models\Catalog\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{

    public function run(): void
    {
        Product::query()->each(function (Product $product) {
            Stock::factory()->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
