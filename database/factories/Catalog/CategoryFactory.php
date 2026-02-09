<?php

namespace Database\Factories\Catalog;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CategoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->words(3, true),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'is_active' => true,
        ];
    }
}
