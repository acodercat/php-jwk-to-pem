<?php

namespace CoderCat\JWKToPEM\Tests;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Exception\JWKConverterException;
use CoderCat\JWKToPEM\JWKConverter;
use PHPUnit\Framework\TestCase;

class JWKConverterTest extends TestCase
{
    private const N = 'vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw';

    private const PEM = "-----BEGIN PUBLIC KEY-----\r\n"
        . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p\r\n"
        . "VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw\r\n"
        . "SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd\r\n"
        . "9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x\r\n"
        . "o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x\r\n"
        . "yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz\r\n"
        . "BwIDAQAB\r\n"
        . "-----END PUBLIC KEY-----";

    /** @var JWKConverter */
    private $jwkConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwkConverter = new JWKConverter();
    }

    private static function rsaPublicKey(array $overrides = []): array
    {
        return array_merge([
            'kty' => 'RSA',
            'kid' => 'zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I',
            'use' => 'sig',
            'alg' => 'RS256',
            'e' => 'AQAB',
            'n' => self::N,
        ], $overrides);
    }

    public function testToPEM()
    {
        $this->assertSame(self::PEM, $this->jwkConverter->toPEM(self::rsaPublicKey()));
    }

    public static function provideInvalidJwk(): array
    {
        $withoutKty = self::rsaPublicKey();
        unset($withoutKty['kty']);
        $withoutN = self::rsaPublicKey();
        unset($withoutN['n']);
        $withoutE = self::rsaPublicKey();
        unset($withoutE['e']);

        return [
            'empty' => [[]],
            'missing kty' => [$withoutKty],
            'missing n' => [$withoutN],
            'missing e' => [$withoutE],
            'non-string n' => [self::rsaPublicKey(['n' => ['foo']])],
            'unsupported key type' => [self::rsaPublicKey(['kty' => 'EC'])],
            'private key' => [self::rsaPublicKey(['d' => 'AQAB'])],
        ];
    }

    /**
     * @dataProvider provideInvalidJwk
     */
    public function testInvalidJwk(array $jwk)
    {
        $this->expectException(JWKConverterException::class);
        $this->jwkConverter->toPEM($jwk);
    }

    public static function provideInvalidBase64(): array
    {
        return [
            'invalid n' => [self::rsaPublicKey(['n' => '!!!'])],
            'invalid e' => [self::rsaPublicKey(['e' => '!!!'])],
        ];
    }

    /**
     * @dataProvider provideInvalidBase64
     */
    public function testInvalidBase64(array $jwk)
    {
        $this->expectException(Base64DecodeException::class);
        $this->jwkConverter->toPEM($jwk);
    }
}
