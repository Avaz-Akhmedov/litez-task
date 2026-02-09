<?php

namespace Database\Factories\Catalog;

use App\Enums\Catalog\StockMovementReason;
use App\Models\Catalog\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;


class StockMovementFactory extends Factory
{

    public function definition(): array
    {
        return [
            'stock_id' => Stock::factory(),
            'quantity_change' => $this->faker->numberBetween(-10, 20),
            'reason' => $this->faker->randomElement(StockMovementReason::cases()),
        ];
    }
}
