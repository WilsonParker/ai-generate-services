<?php

namespace AIGenerate\Services\AI\OpenAI\Traits;

trait HasCommonRules
{

    public function commonRules(): array
    {
        return [
            "order" => [
                'nullable',
                'string',
            ],
            "max_tokens" => [
                'required',
                'numeric',
                'min:1',
                'max:2048',
            ],
            'language' => [
                'nullable',
                'string',
            ],
            'tone' => [
                'nullable',
                'string',
            ],
            'writing_style' => [
                'nullable',
                'string',
            ],
        ];
    }
}
