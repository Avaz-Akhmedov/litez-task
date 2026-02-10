<?php

namespace App\Services\Catalog;

use App\Enums\Catalog\StockMovementReason;
use App\Models\Catalog\Stock;
use App\Models\Catalog\StockMovement;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function adjustStock(int $productId, int $quantityChange, StockMovementReason $reason)
    {
        return DB::transaction(function () use ($productId, $quantityChange, $reason) {

            $stock = Stock::query()
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->firstOrFail();

            $newQuantity = $stock->quantity + $quantityChange;

            if ($newQuantity < 0) {
                throw ValidationException::withMessages([
                    'quantity_change' => ["На складе : {$stock->quantity}ед., списание 100 невозможно {$quantityChange}"]
                ]);
            }
            $stock->quantity = $newQuantity;


            if ($reason === StockMovementReason::Sale) {
                $available = $stock->quantity - $stock->reserved_quantity;

                if ($available < abs($quantityChange)) {
                    throw ValidationException::withMessages([
                        'quantity_change' => ["Товар зарезервирован. В наличии.: {$available}, Сдержанный: {$stock->reserved_quantity}"]
                    ]);
                }
            }


            $stock->save();


            StockMovement::query()->create([
                'stock_id' => $stock->id,
                'quantity_change' => $quantityChange,
                'reason' => $reason,
            ]);


            return $stock->load('movements');
        });
    }


    public function getHistory(int $productId): LengthAwarePaginator
    {
        $stock = Stock::query()
            ->where('product_id', $productId)
            ->firstOrFail();


        return $stock->movements()->latest()->paginate(20);
    }
}
