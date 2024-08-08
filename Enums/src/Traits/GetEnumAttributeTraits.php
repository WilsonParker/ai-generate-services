<?php

namespace AIGenerate\Services\Enums\Traits;

use Illuminate\Support\Collection;

trait GetEnumAttributeTraits
{
    public static function getEnumAttributeValues($value = 'value'): Collection
    {
        return collect(self::cases())->map(fn($item) => $item->$value);
    }

    public static function getEnumAttributes($key = 'name', $value = 'value', callable|string $keyCallback = null, callable|string $valueCallback = null): Collection
    {
        return collect(self::cases())
            ->map(function ($item) use ($key, $value, $keyCallback, $valueCallback) {

                if (isset($keyCallback)) {
                    if (is_callable($keyCallback)) {
                        $v1 = $keyCallback($item);
                    } else {
                        $v1 = $item->$keyCallback;
                    }
                } else {
                    $v1 = $item->name;
                }

                if (isset($valueCallback)) {
                    if (is_callable($valueCallback)) {
                        $v2 = $valueCallback($item);
                    } else {
                        $v2 = $item->$valueCallback;
                    }
                } else {
                    $v2 = $item->value;
                }

                return [
                    $key => $v1,
                    $value => $v2,
                ];
            });
    }
}
