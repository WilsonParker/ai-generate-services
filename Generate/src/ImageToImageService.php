<?php

namespace App\Modules\Services\Generate\src;

use App\Http\Repositories\Generate\ImageToImageGenerateExportRepository;
use App\Http\Repositories\Generate\ImageToImageRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Contracts\ImageToImageServiceContract;
use AIGenerate\Services\Generate\Enums\ImageToImageType;
use AIGenerate\Services\Generate\Enums\SamplingMethod;

class ImageToImageService extends BaseService implements ImageToImageServiceContract
{
    public function __construct(
        private readonly ImageToImageRepository $repository,
        private readonly ImageToImageGenerateExportRepository $exportRepository,
    ) {}

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
        string $additional = '',)
    {
        if ($fillPrompt) {
            $prompt = Str::of(config('stock-generate.portrait_text_generate_prompt'))->replace('$prompt', $prompt);
        }

        $lora = '<lora:vodka_portraits:0.3>';
        $prompt .= ', ' . $lora;

        if ($fillNegative) {
            $negative .= ',' . config('stock-generate.negative');
        }

        $payload = [
            'id'                 => $user->getKey(),
            'user_id'            => $user->getKey(),
            'image_cfg_scale'    => $cfgScale,
            'denoising_strength' => $denoisingStrength,
            'type'               => $type->value,
            'width'              => $width,
            'height'             => $height,
            'prompt'             => $prompt,
            'negative'           => $negative,
            'alwayson_scripts'   => json_encode($extension),
            'additional'         => $additional,
        ];

        $generate = $this->repository->store(
            user             : $user,
            type             : $type,
            prompt           : $prompt,
            negative         : $negative,
            width            : $width,
            height           : $height,
            method           : $method,
            steps            : $steps,
            cfgScale         : $cfgScale,
            denoisingStrength: $denoisingStrength,
            seed             : $seed,
            alwaysonScripts  : $extension,
            payload          : json_encode($payload),
        );
        $payload['id'] = $generate->getKey();
        $generate->addMedia($image)->usingFileName(Str::random(32) . '.' . $image->extension())->toMediaCollection('origin');

        $response = Http::post(config('stock-generate.ai_image_generate_url'), [
            'image'              => $generate->originImage()->first()->getUrl(),
            'prompt'             => $prompt,
            'negative'           => $negative,
            'type'               => 'generate',
            'width'              => $width,
            'height'             => $height,
            'image_cfg_scale'    => $cfgScale,
            'denoising_strength' => $denoisingStrength,
            'callback_url'       => $callbackUrl,
            'alwayson_scripts'   => '{"ADetailer":{"args":{"0":"true","1" : {"ad_model":"face_yolov8n.pt"}}}}',
            'payload'            => json_encode($payload),
        ]);
        throw_if($response->serverError(), new Exception($response->body()));
        return $response->body();
    }

    protected function getRepository()
    {
        return $this->repository;
    }

    protected function getExportRepository()
    {
        return $this->exportRepository;
    }
}
