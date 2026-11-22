<?php

namespace CoderCat\JWKToPEM\Tests\Util;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Util\Base64UrlDecoder;
use PHPUnit\Framework\TestCase;

class Base64UrlDecoderTest extends TestCase
{
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
    public function testDecode(string $input, string $expected)
    {
        $this->assertSame($expected, (new Base64UrlDecoder())->decode($input));
    }

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
    public function testInvalid(string $input)
    {
        $this->expectException(Base64DecodeException::class);
        (new Base64UrlDecoder())->decode($input);
    }
}
