<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductAttributeFactory extends Factory
{

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'name' => $this->faker->sentence(rand(1,6)),
            'value' => $this->faker->sentence(rand(1,11)),
        ];
    }
}
