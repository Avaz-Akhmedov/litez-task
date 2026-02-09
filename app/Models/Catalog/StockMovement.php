<?php

namespace App\Models\Catalog;

use App\Enums\Catalog\StockMovementReason;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'quantity_change', 'reason'];

    protected $casts = [
        'reason' => StockMovementReason::class,
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
