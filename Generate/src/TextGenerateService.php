<?php

namespace AIGenerate\Services\Generate;

use App\Http\Repositories\Generate\TextGenerateExportRepository;
use App\Http\Repositories\Generate\TextGenerateRepository;
use App\Models\Generate\TextGenerate;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use AIGenerate\Models\Stock\Enums\Ethnicity;
use AIGenerate\Models\Stock\Enums\Gender;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Contracts\TextGenerateServiceContract;
use AIGenerate\Services\Generate\Enums\TextGenerateType;
use AIGenerate\Services\Keyword\KeywordFilterService;

class TextGenerateService implements TextGenerateServiceContract
{
    public function __construct(
        private TextGenerateRepository $repository,
        private TextGenerateExportRepository $exportRepository,
        private KeywordFilterService $keywordFilterService,
    ) {}

    /**
     * @throws \Throwable
     */
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
        string $additional = '',
    ) {
        $input = $prompt;
        $this->keywordFilterService->hasInvalidKeyword($prompt, true);

        $denoisingStrength = 0.75;
        $cfgScale = 3.5;
        if ($type->value === TextGenerateType::Portrait->value) {
            $lora = $isSkinReality ? '<lora:vodka_portraits:0.3>' : null;
            $ethnicity = $ethnicity?->value;
            $age = $age ? "$age years old " : '';
            $gender = $gender?->value;
            $data = collect([
                $prompt,
                $ethnicity,
                $age . $gender,
            ])->filter()->implode(', ');
            $prompt = Str::of(config('stock-generate.portrait_text_generate_prompt'))->replace('$prompt', $data);
            if ($lora) {
                $prompt .= ', ' . $lora;
            }
        } else {
            $lora = null;
            $ethnicity = null;
            $age = null;
            $gender = null;
            $prompt = Str::of(config('stock-generate.text_generate_prompt'))->replace('$prompt', $prompt);
        }
        $negative = config('stock-generate.negative');

        $payload = [
            'user_id'            => $user->getKey(),
            'denoising_strength' => $denoisingStrength,
            'image_cfg_scale'    => $cfgScale,
            'type'               => $type->value,
            'ratio'              => 'custom',
            'width'              => $width,
            'height'             => $height,
            'lora'               => $lora,
            'age'                => $age,
            'ethnicity'          => $ethnicity,
            'gender'             => $gender,
            'prompt'             => $prompt,
            'input'              => $input,
            'additional'         => $additional,
        ];

        $generate = $this->repository->store(
            user         : $user,
            type         : \AIGenerate\Models\Generate\Enums\TextGenerateType::tryFrom($payload['type']),
            width        : $width,
            height       : $height,
            prompt       : $payload['prompt'],
            ethnicity    : $payload['gender'] ?? null,
            gender       : $payload['ethnicity'] ?? null,
            age          : $payload['age'] ? (int)$payload['age'] : null,
            isSkinReality: $payload['isSkinReality'] ?? false,
        );
        $payload['id'] = $generate->getKey();

        $response = Http::post(config('stock-generate.ai_text_generate_url'), [
            'prompt'             => $prompt,
            'negative'           => $negative,
            'type'               => 'generate',
            'width'              => $width,
            'height'             => $height,
            'denoising_strength' => $denoisingStrength,
            'image_cfg_scale'    => $cfgScale,
            'callback_url'       => $callbackUrl,
            'alwayson_scripts'   => '{"ADetailer":{"args":{"0":"true","1" : {"ad_model":"face_yolov8n.pt"}}}}',
            'payload'            => json_encode($payload),
        ]);
        throw_if($response->serverError(), new Exception($response->body()));
        return $response->body();
    }

    public function index(Authenticatable $auth, int $page, int $size): Paginator
    {
        return $this->repository->index($auth, $page, $size);
    }

    public function destroy(TextGenerate $generate): bool
    {
        return $this->repository->destroy($generate);
    }

    public function storeExport(TextGenerate $generate)
    {
        return $this->exportRepository->store($generate);
    }
}
