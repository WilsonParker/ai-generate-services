<?php

namespace AIGenerate\Services\Cache\Traits;

trait CacheKeyTraits
{
    public function makeCacheKey(array $params): string
    {
        return collect($params)->filter()->implode('@');
    }
}