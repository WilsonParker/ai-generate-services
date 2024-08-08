<?php

namespace AIGenerate\Services\Generate\Contracts;

use App\Models\Generate\ImageToImageGenerate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Enums\ImageToImageType;
use AIGenerate\Services\Generate\Enums\SamplingMethod;

interface ImageToImageServiceContract extends GenerateServiceContract
{
    public function generate(
        User $user,
        ImageToImageType $type,
        string $callbackUrl,
        string|UploadedFile $image,
        bool $fillPrompt,
        string $prompt,
        bool $fillNegative,
        ?string $negative,
        int $width,
        int $height,
        SamplingMethod $method = SamplingMethod::DPM_PP_2M_SDE_KARRAS,
        int $steps = 20,
        $cfgScale = 7.0,
        $denoisingStrength = 0.75,
        int $seed = -1,
        array $extension = [],
        string $additional = '',
    );

    public function index(User $user, int $page, int $size);

    public function destroy(ImageToImageGenerate|Model $generate): bool;

    public function storeExport(ImageToImageGenerate|Model $generate);

}
