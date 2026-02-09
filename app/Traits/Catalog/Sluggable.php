<?php

namespace App\Traits\Catalog;

use App\Services\Catalog\SlugService;

trait Sluggable
{
    protected static function bootSluggable(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = SlugService::generate(
                    $model,
                    $model->{static::slugSource()}
                );
            }
        });
    }

    protected static function slugSource(): string
    {
        return 'name';
    }
}

