<?php

namespace AIGenerate\Services\Keyword\Tests;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use AIGenerate\Services\Keyword\KeywordFilterService;
use Tests\TestCase;

class KeywordTest extends TestCase
{
    public function test_keyword_is_contains(): void
    {
        $isContains = function ($content, $keyword): bool {
            $removeReg = "/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}0-9]/i";
            $separate = preg_split($removeReg, $content);
            // Escape special characters in the keyword for regex
            $escapedKeyword = Str::of(preg_quote($keyword, '/'))->lower();

            foreach ($separate as $item) {
                $replace = Str::of(preg_replace($removeReg, '', $item))->lower();
                if (Str::of($replace)->exactly($escapedKeyword)) {
                    return true;
                }
            }
            return false;
        };
        $this->assertTrue($isContains('Hello1World2', 'world'));
        $this->assertTrue($isContains('Hello..World.', 'World'));
        $this->assertFalse($isContains('Hello World', 'orld'));
        $this->assertTrue($isContains('Hello World', 'World'));
        $this->assertTrue($isContains('Hello World ', 'World'));
        $this->assertTrue($isContains('Hello.World.', 'World'));
        $this->assertTrue($isContains('Hello..World', 'World'));
        $this->assertTrue($isContains('Hello.World..', 'World'));
        $this->assertTrue($isContains('Hello World..', 'World'));
        $this->assertTrue($isContains('Hello1World2', 'World'));
        $this->assertTrue($isContains('Hello11World2', 'world'));
        $this->assertTrue($isContains('Hello11World22', 'world'));
        $this->assertTrue($isContains('Hello1World', 'world'));
        $this->assertFalse($isContains('Hello Worldn', 'World'));
        $this->assertFalse($isContains('Hello.Worldn', 'World'));
    }

    public function test_keyword_is_contains2(): void
    {
        $isContains = function ($content, $keyword): bool {
            // Escape special characters in the keyword for regex
            $escapedKeyword = preg_quote($keyword, '/');

            $subReg = "[0-9\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"\b]";
            // Create the regex pattern to match the keyword in different contexts
            $reg = "/(($subReg)*|(^$subReg).)$escapedKeyword($subReg)*/i";

            // Assuming isMatch is a method that accepts a regex pattern
            return Str::of($content)->isMatch($reg);
        };
        $this->assertTrue($isContains('Hello World', 'World'));
        $this->assertTrue($isContains('Hello World ', 'World'));
        $this->assertTrue($isContains('Hello.World.', 'World'));
        $this->assertTrue($isContains('Hello..World.', 'World'));
        $this->assertTrue($isContains('Hello..World', 'World'));
        $this->assertTrue($isContains('Hello.World..', 'World'));
        $this->assertTrue($isContains('Hello World..', 'World'));
        $this->assertTrue($isContains('Hello1World2', 'World'));
        $this->assertTrue($isContains('Hello1World2', 'world'));
        $this->assertTrue($isContains('Hello11World2', 'world'));
        $this->assertTrue($isContains('Hello11World22', 'world'));
        $this->assertTrue($isContains('Hello1World', 'world'));
        $this->assertFalse($isContains('Hello World', 'orld'));
        $this->assertFalse($isContains('Hello Worldn', 'World'));
        $this->assertFalse($isContains('Hello.Worldn', 'World'));
    }

    public function test_keyword_is_correct(): void
    {
        $service = app()->make(KeywordFilterService::class);

        $this->assertTrue($service->hasInvalidKeyword('gl1ass'));
        $this->assertTrue($service->hasInvalidKeyword('gl.ass'));
        $this->assertTrue($service->hasInvalidKeyword('gl.ass  '));
        $this->assertTrue($service->hasInvalidKeyword('gl .ass..'));
        $this->assertTrue($service->hasInvalidKeyword('gl.ass.2'));
        $this->assertTrue($service->hasInvalidKeyword('gl.ass2'));
        $this->assertTrue($service->hasInvalidKeyword('gl1ass'));
        $this->assertTrue($service->hasInvalidKeyword('ass'));
        $this->assertTrue($service->hasInvalidKeyword(' ass '));
        $this->assertTrue($service->hasInvalidKeyword('.ass.'));
        $this->assertTrue($service->hasInvalidKeyword('1ass1'));
        $this->assertTrue($service->hasInvalidKeyword('  ass  '));

        $this->assertFalse($service->hasInvalidKeyword('glass'));
        $this->assertFalse($service->hasInvalidKeyword('glass2'));
        $this->assertFalse($service->hasInvalidKeyword('g.lass2'));
        $this->assertFalse($service->hasInvalidKeyword('g.lass..'));
    }

}
