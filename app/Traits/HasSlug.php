<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public function getRouteName(): string
    {
        return 'slug';
    }
    public static function bootHasSlug():void
    {
        static::saving(function ($model)
        {
            $model->slug = Str::slug($model->name);
        });
    }
}
