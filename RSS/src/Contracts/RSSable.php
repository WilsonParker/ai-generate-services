<?php

namespace AIGenerate\Services\RSS\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Feed\Feedable;

interface RSSable extends Feedable
{
    public function rssExportHistory(): MorphOne;
}
