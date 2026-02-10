<?php

namespace App\Models\Catalog;

use App\Traits\Catalog\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sku',
        'category_id',
        'is_published'
    ];
    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


}
