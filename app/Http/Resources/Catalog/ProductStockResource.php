<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'reserved_quantity' => $this->reserved_quantity,
            'stock_movement' => StockMovementResource::collection($this->whenLoaded('movements'))
        ];
    }
}
