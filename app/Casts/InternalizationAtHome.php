<?php

namespace App\Casts;

use App\Enums\InternationalizationAtHomeEnum as EnumsInternationalizationAtHomeEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InternalizationAtHome implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return EnumsInternationalizationAtHomeEnum::tryFrom($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value instanceof EnumsInternationalizationAtHomeEnum ? $value->value : $value;
    }
}
