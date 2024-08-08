<?php

namespace AIGenerate\Services\Google\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleToken extends Model
{
    protected $table = 'google_tokens';
    protected $fillable = ['token'];
}
