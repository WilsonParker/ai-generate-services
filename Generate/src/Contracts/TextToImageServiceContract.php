<?php

namespace AIGenerate\Services\Generate\Contracts;

use Illuminate\Database\Eloquent\Model;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Enums\SamplingMethod;
use AIGenerate\Services\Generate\Enums\TextToImageType;

interface TextToImageServiceContract extends GenerateServiceContract
{
    public function generate(
        User $user,
        TextToImageType $type,
        string $callbackUrl,
        bool $fillPrompt,
        string $prompt,
        bool $fillNegative,
        ?string $negative,
        int $width,
        int $height,
        SamplingMethod $method = SamplingMethod::DPM_PP_2M_SDE_KARRAS,
        int $steps = 20,
        $cfgScale = 7.0,
        int $seed = -1,
        array $extension = [],
        string $additional = '',
    );

    public function index(User $user, int $page, int $size);

    public function destroy(Model $generate): bool;

    public function storeExport(Model $generate);

}
