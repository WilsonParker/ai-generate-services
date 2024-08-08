<?php

namespace AIGenerate\Services\Generate\Contracts;

use App\Models\Generate\TextGenerate;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use AIGenerate\Models\Stock\Enums\Ethnicity;
use AIGenerate\Models\Stock\Enums\Gender;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Enums\TextGenerateType;

interface TextGenerateServiceContract
{
    public function generate(
        string $prompt,
        User $user,
        int $width,
        int $height,
        TextGenerateType $type,
        ?Ethnicity $ethnicity,
        ?Gender $gender,
        ?int $age,
        bool $isSkinReality,
        string $callbackUrl,
        string $additional = '');

    public function index(Authenticatable $auth, int $page, int $size): Paginator;

    public function storeExport(TextGenerate $generate);

}
