<?php

namespace App\Services\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    public static function generate(Model $model, string $value, string $column = 'slug'): string
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $i = 1;

        while (
        $model->newQuery()
            ->where($column, $slug)
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        return $slug;
    }
}
