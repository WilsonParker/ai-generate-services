<?php

namespace AIGenerate\Services\RSS\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use AIGenerate\Services\RSS\Models\RssExportHistory;

trait RssExportTraits
{

    public function rssExportHistory(): MorphOne
    {
        return $this->morphOne(RssExportHistory::class, 'rss', 'model_type', 'model_id', 'id');
    }
}
