<?php

namespace Catalog;

use App\Models\Catalog\Product;
use App\Models\Catalog\Stock;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use DatabaseTransactions;

    public function test_stock_adjustment_prevents_negative(): void
    {
        $product = Product::factory()->create();


        Stock::factory()->create([
            'product_id' => $product->id,
            'quantity' => 10
        ]);

        $response = $this->postJson("/api/inventory/{$product->id}/adjust", [
            'quantity_change' => -20,
            'reason' => 'sale'
        ]);

        $response->assertUnprocessable();

        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'quantity' => 10
        ]);
    }

    public function test_stock_adjustment_logs_movement(): void
    {
        $product = Product::factory()->create();

        Stock::factory()->create([
            'product_id' => $product->id,
            'quantity' => 10
        ]);

        $response = $this->postJson("/api/inventory/{$product->id}/adjust", [
            'quantity_change' => 5,
            'reason' => 'receipt'
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('stocks', ['quantity' => 15]);


        $this->assertDatabaseHas('stock_movements', [
            'stock_id' => $product->stock->id,
            'quantity_change' => 5,
            'reason' => 'receipt'
        ]);
    }
}
