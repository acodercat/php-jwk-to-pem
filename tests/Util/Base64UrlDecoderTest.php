<?php

namespace CoderCat\JWKToPEM\Tests\Util;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Util\Base64UrlDecoder;
use PHPUnit\Framework\TestCase;

class Base64UrlDecoderTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function provideDecode(): array
    {
        return [
            'url-safe alphabet' => ['-_8', "\xfb\xff"],
            'without padding' => ['AQAB', "\x01\x00\x01"],
            'falsy result' => ['MA', '0'],
        ];
    }

    /**
     * @dataProvider provideDecode
     */
    public function testDecode(string $input, string $expected): void
    {
        $this->assertSame($expected, (new Base64UrlDecoder())->decode($input));
    }

    /**
     * @return array<string, array{string}>
     */
    public static function provideInvalid(): array
    {
        return [
            'empty' => [''],
            'invalid characters' => ['!!!'],
        ];
    }

    /**
     * @dataProvider provideInvalid
     */
    public function testInvalid(string $input): void
    {
        $this->expectException(Base64DecodeException::class);
        (new Base64UrlDecoder())->decode($input);
    }
}
