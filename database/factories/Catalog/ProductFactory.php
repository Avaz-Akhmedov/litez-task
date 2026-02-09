<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Services\Catalog\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ProductFactory extends Factory
{

    public function definition(): array
    {
        $name = $this->faker->sentence(rand(1,15));
        return [
            'name' => $name,
            'slug'=> SlugService::generate(new Product(),$name),
            'sku' =>strtoupper($this->faker->bothify('??-####')),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'category_id' => Category::factory(),
            'is_published' => true,
        ];
    }
}
