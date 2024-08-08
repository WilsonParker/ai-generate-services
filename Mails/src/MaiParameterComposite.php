<?php

namespace AIGenerate\Services\Mails;

use Illuminate\Support\Arr;

class MaiParameterComposite
{

    /**
     * @var $composites array<\AIGenerate\Services\Mails\Composites\Contracts\ParameterContracts>
     */
    public function __construct(protected array $composites) {}

    public function bindParams(array $params, array $data = []): array
    {
        $result = [];
        foreach ($this->composites as $composite) {
            if ($composite->hasParams($params)) {
                $result = array_merge($result, $composite->bindParams($params, $data));
            }
        }
        return Arr::undot($result);
    }

}