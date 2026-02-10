<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'stock_id' => $this->stock_id,
            'quantity_change' => $this->quantity_change,
            'reason' => $this->quantity_change
        ];
    }
}
