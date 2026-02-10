<?php

namespace App\Filters\Catalog;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    public function apply(Builder $query, array $filters)
    {
        return $query
            ->when($filters['search'] ?? null, function ($q, $search) {
                return $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['category_id'] ?? null, fn($q, $categoryId) => $q->where('category_id', $categoryId)
            )
            ->when($filters['price_min'] ?? null, fn($q, $priceMin) => $q->where('price', '>=', $priceMin)
            )
            ->when($filters['price_max'] ?? null, fn($q, $priceMax) => $q->where('price', '<=', $priceMax)
            );
    }
}
