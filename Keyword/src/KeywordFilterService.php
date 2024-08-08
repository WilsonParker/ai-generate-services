<?php

namespace AIGenerate\Services\Keyword;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use AIGenerate\Services\Keyword\Exceptions\InvalidKeywordException;

class KeywordFilterService
{
    protected array|Collection $keywords;

    protected string $removeReg = "/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}0-9]/i";

    public function __construct()
    {
        $this->keywords = config('word_filter');
    }

    /**
     * @throws \Throwable
     */
    public function hasInvalidKeyword(string $content, bool $throw = false): bool
    {
        foreach ($this->getInvalidKeywords() as $keyword) {
            $separate = preg_split($this->removeReg, $content);
            $convertedKeyword = Str::of($keyword)->lower();
            foreach ($separate as $item) {
                $replace = Str::of(preg_replace($this->removeReg, '', $item))->lower();
                if (Str::of($replace)->exactly($convertedKeyword)) {
                    throw_if($throw, new InvalidKeywordException());
                    return true;
                }
            }
        }
        return false;
    }

    private function getInvalidKeywords(): array|Collection
    {
        return $this->keywords;
    }
}
