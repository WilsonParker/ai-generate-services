<?php

namespace AIGenerate\Services\Generate\Enums;

use Exception;
use Illuminate\Support\Collection;

enum Ratio: string
{
    case Square   = 'square';
    case Wide     = 'wide';
    case Vertical = 'vertical';

    /**
     * @throws Exception
     */
    public function getRatio(): array
    {
        return match ($this) {
            self::Square => [
                'width'  => 768,
                'height' => 768,
            ],
            self::Wide => [
                'width'  => 896,
                'height' => 768,
            ],
            self::Vertical => [
                'width'  => 768,
                'height' => 896,
            ],
        };
    }

    public static function getEnumAttributes($key = 'name', $value = 'value'): Collection
    {
        return collect(self::cases())
            ->map(fn($item) => [
                $key => $item->name,
                ...$item->getRatio(),
            ]);
    }
}
