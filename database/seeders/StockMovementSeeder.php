<?php

namespace Database\Seeders;

use App\Models\Catalog\Stock;

use App\Models\Catalog\StockMovement;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{

    public function run(): void
    {
        Stock::query()->each(function (Stock $stock) {
            StockMovement::factory()->create([
                'stock_id' => $stock->id
            ]);
        });
    }
}
