<?php

namespace AIGenerate\Services\RSS\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use AIGenerate\Models\BaseModel;

class RssExportHistory extends BaseModel
{
    protected $table = 'rss_export_history';

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
