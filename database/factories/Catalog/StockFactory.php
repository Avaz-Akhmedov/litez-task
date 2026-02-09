<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class StockFactory extends Factory
{

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(10, 100),
            'reserved_quantity' => 0,
        ];
    }
}
