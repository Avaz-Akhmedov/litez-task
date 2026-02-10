<?php

namespace App\Http\Controllers\Catalog;

use App\Enums\Catalog\StockMovementReason;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\AdjustInventoryRequest;
use App\Http\Resources\Catalog\ProductStockResource;
use App\Http\Resources\Catalog\StockMovementResource;
use App\Services\Catalog\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InventoryController extends Controller
{
    public function __construct(protected InventoryService $service){}

    public function adjust(AdjustInventoryRequest $request, int $productId): JsonResponse
    {
        $data = $request->validated();

        $stock = $this->service->adjustStock(
            $productId,
            (int)$data['quantity_change'],
            StockMovementReason::from($data['reason'])
        );

        return response()->json([
            'message' => 'Stock updated successfully',
            'data' => ProductStockResource::make($stock)
        ]);
    }


    public function history(int $productId): AnonymousResourceCollection
    {
        $stockMovement = $this->service->getHistory($productId);

        return StockMovementResource::collection($stockMovement);
    }


}
