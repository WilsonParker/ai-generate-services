<?php

namespace AIGenerate\Services\Generate;

use App\Http\Repositories\Generate\TextToImageGenerateExportRepository;
use App\Http\Repositories\Generate\TextToImageRepository;
use App\Modules\Services\Generate\src\BaseService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Contracts\TextToImageServiceContract;
use AIGenerate\Services\Generate\Enums\SamplingMethod;
use AIGenerate\Services\Generate\Enums\TextToImageType;

class TextToImageService extends BaseService implements TextToImageServiceContract

{
    public function __construct(
        private readonly TextToImageRepository $repository,
        private readonly TextToImageGenerateExportRepository $exportRepository,
    ) {}

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
        string $additional = '')
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
            'id'               => $user->getKey(),
            'user_id'          => $user->getKey(),
            'image_cfg_scale'  => $cfgScale,
            'type'             => $type->value,
            'width'            => $width,
            'height'           => $height,
            'prompt'           => $prompt,
            'negative'         => $negative,
            'alwayson_scripts' => json_encode($extension),
            'additional'       => $additional,
        ];

        $generate = $this->repository->store(
            user           : $user,
            type           : $type,
            prompt         : $prompt,
            negative       : $negative,
            width          : $width,
            height         : $height,
            method         : $method,
            steps          : $steps,
            cfgScale       : $cfgScale,
            seed           : $seed,
            alwaysonScripts: $extension,
            payload        : json_encode($payload),
        );
        $payload['id'] = $generate->getKey();

        $response = Http::post(config('stock-generate.ai_text_generate_url'), [
            'prompt'           => $prompt,
            'negative'         => $negative,
            'type'             => 'generate',
            'width'            => $width,
            'height'           => $height,
            'image_cfg_scale'  => $cfgScale,
            'callback_url'     => $callbackUrl,
            'alwayson_scripts' => '{"ADetailer":{"args":{"0":"true","1" : {"ad_model":"face_yolov8n.pt"}}}}',
            'payload'          => json_encode($payload),
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
