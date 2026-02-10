<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description'=> $this->description,
            'price'=> $this->price,
            'sku'=> $this->sku,
            'is_published' => $this->is_published,
            'created_at' => $this->created_at->toDatetimeString(),
            'category'  =>CategoryResource::make($this->whenLoaded('category')),
            'attributes' => ProductAttributeResource::collection($this->whenLoaded('attributes')),
            'stock' => ProductStockResource::make($this->whenLoaded('stock'))
        ];
    }
}
