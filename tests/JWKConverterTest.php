<?php

namespace CoderCat\JWKToPEM\Tests;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Exception\JWKConverterException;
use CoderCat\JWKToPEM\JWKConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JWKConverterTest extends TestCase
{
    /** @var JWKConverter */
    private $jwkConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwkConverter = new JWKConverter();
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function rsaPublicKey(array $overrides = []): array
    {
        return array_merge([
            'kty' => 'RSA',
            'kid' => 'zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I',
            'use' => 'sig',
            'alg' => 'RS256',
            'e' => 'AQAB',
            'n' => 'vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw',
        ], $overrides);
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function ecPublicKey(array $overrides = []): array
    {
        return array_merge([
            'kty' => 'EC',
            'crv' => 'P-256',
            'x' => 'z-NPCaGCMhI6how5Ujj4udNfAnphLXNZ71IU_VGooRU',
            'y' => '-Ulv1IoijhEc9i2URAL8XRq8FKQ-HdKH0byaj3w0Moc',
        ], $overrides);
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function okpPublicKey(array $overrides = []): array
    {
        return array_merge([
            'kty' => 'OKP',
            'crv' => 'Ed25519',
            'x' => 'eig-fhwmuMU0jLWcnIXuHKfYYNUV4g5xtbESLLW9hx4',
        ], $overrides);
    }

    /**
     * @param array<string, mixed> $jwk
     * @return array<string, mixed>
     */
    private static function without(array $jwk, string $name): array
    {
        unset($jwk[$name]);

        return $jwk;
    }

    /**
     * Expected PEMs were generated with OpenSSL.
     *
     * @return array<string, array{array<string, mixed>, string}>
     */
    public static function provideToPEM(): array
    {
        return [
            'RSA' => [
                self::rsaPublicKey(),
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p\r\n"
                . "VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw\r\n"
                . "SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd\r\n"
                . "9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x\r\n"
                . "o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x\r\n"
                . "yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz\r\n"
                . "BwIDAQAB\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'EC P-256' => [
                [
                    'kty' => 'EC',
                    'crv' => 'P-256',
                    'x' => 'z-NPCaGCMhI6how5Ujj4udNfAnphLXNZ71IU_VGooRU',
                    'y' => '-Ulv1IoijhEc9i2URAL8XRq8FKQ-HdKH0byaj3w0Moc',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEz+NPCaGCMhI6how5Ujj4udNfAnph\r\n"
                . "LXNZ71IU/VGooRX5SW/UiiKOERz2LZREAvxdGrwUpD4d0ofRvJqPfDQyhw==\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'EC P-384' => [
                [
                    'kty' => 'EC',
                    'crv' => 'P-384',
                    'x' => 'ZaFkbyXFqD_DO0i8iLt3dJDYddOoX1y6p49KbkiPB8rNuvqAfXuJQyAgGKZv9a9s',
                    'y' => 'StviBr9kbKhUDIq7IDxia_ix9uZ-4SbxgPX08lZJzmOGRvdSjlkHiO1cL0ruNIfY',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MHYwEAYHKoZIzj0CAQYFK4EEACIDYgAEZaFkbyXFqD/DO0i8iLt3dJDYddOoX1y6\r\n"
                . "p49KbkiPB8rNuvqAfXuJQyAgGKZv9a9sStviBr9kbKhUDIq7IDxia/ix9uZ+4Sbx\r\n"
                . "gPX08lZJzmOGRvdSjlkHiO1cL0ruNIfY\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'EC P-521' => [
                [
                    'kty' => 'EC',
                    'crv' => 'P-521',
                    'x' => 'Adry0PS18FZZQOcwf713b5irquZWYactEorge1wnAiah6PpmyBiyXmIKWw4zIJgXch8AkG8yhbl0WJtaGj7mbHD2',
                    'y' => 'AcUMrI4tJrI-lgprBecHWuTOwOu9B7OXwXv1OH06CLGDRqepCZIx67CdvgeLoxljsVlt8dv8KXhXbmnyzPT3SXoR',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MIGbMBAGByqGSM49AgEGBSuBBAAjA4GGAAQB2vLQ9LXwVllA5zB/vXdvmKuq5lZh\r\n"
                . "py0SiuB7XCcCJqHo+mbIGLJeYgpbDjMgmBdyHwCQbzKFuXRYm1oaPuZscPYBxQys\r\n"
                . "ji0msj6WCmsF5wda5M7A670Hs5fBe/U4fToIsYNGp6kJkjHrsJ2+B4ujGWOxWW3x\r\n"
                . "2/wpeFduafLM9PdJehE=\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'EC secp256k1' => [
                [
                    'kty' => 'EC',
                    'crv' => 'secp256k1',
                    'x' => 'Nx38CpwZ10XsvpEDJLk96jb12kBnwxw0ssWzG1rC_wQ',
                    'y' => 'gHUAse2Mi9IkXBOTZN4eMTPevNcxxDNHgUMaecWqVOU',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAENx38CpwZ10XsvpEDJLk96jb12kBnwxw0\r\n"
                . "ssWzG1rC/wSAdQCx7YyL0iRcE5Nk3h4xM9681zHEM0eBQxp5xapU5Q==\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'OKP Ed25519' => [
                [
                    'kty' => 'OKP',
                    'crv' => 'Ed25519',
                    'x' => 'eig-fhwmuMU0jLWcnIXuHKfYYNUV4g5xtbESLLW9hx4',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MCowBQYDK2VwAyEAeig+fhwmuMU0jLWcnIXuHKfYYNUV4g5xtbESLLW9hx4=\r\n"
                . "-----END PUBLIC KEY-----",
            ],
            'OKP Ed448' => [
                [
                    'kty' => 'OKP',
                    'crv' => 'Ed448',
                    'x' => 'G97hb6BbbmCeRM5Fh-7zHexILdOlvlzTiOzzAFUJs3vAP9mhiWha9TLYnBjfK9EZzXMfxTyj_JqA',
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MEMwBQYDK2VxAzoAG97hb6BbbmCeRM5Fh+7zHexILdOlvlzTiOzzAFUJs3vAP9mh\r\n"
                . "iWha9TLYnBjfK9EZzXMfxTyj/JqA\r\n"
                . "-----END PUBLIC KEY-----",
            ],
        ];
    }

    /**
     * @param array<string, mixed> $jwk
     */
    #[DataProvider('provideToPEM')]
    public function testToPEM(array $jwk, string $expected): void
    {
        $this->assertSame($expected, $this->jwkConverter->toPEM($jwk));
    }

    public function testAcceptsStandardBase64AlphabetAndPadding(): void
    {
        $jwk = self::rsaPublicKey();
        $this->assertIsString($jwk['n']);
        $jwk['n'] = strtr($jwk['n'], '-_', '+/') . '==';

        $this->assertSame(
            $this->jwkConverter->toPEM(self::rsaPublicKey()),
            $this->jwkConverter->toPEM($jwk)
        );
    }

    /**
     * @return array<string, array{array<string, mixed>}>
     */
    public static function provideInvalidJwk(): array
    {
        return [
            'empty' => [[]],
            'missing kty' => [self::without(self::rsaPublicKey(), 'kty')],
            'unsupported key type' => [['kty' => 'oct', 'k' => 'AQAB']],
            'RSA private key' => [self::rsaPublicKey(['d' => 'AQAB'])],
            'RSA missing n' => [self::without(self::rsaPublicKey(), 'n')],
            'RSA missing e' => [self::without(self::rsaPublicKey(), 'e')],
            'RSA non-string n' => [self::rsaPublicKey(['n' => ['foo']])],
            'EC private key' => [self::ecPublicKey(['d' => 'AQAB'])],
            'EC missing crv' => [self::without(self::ecPublicKey(), 'crv')],
            'EC missing x' => [self::without(self::ecPublicKey(), 'x')],
            'EC missing y' => [self::without(self::ecPublicKey(), 'y')],
            'EC unsupported curve' => [self::ecPublicKey(['crv' => 'P-192'])],
            'EC point not on curve' => [self::ecPublicKey(['y' => 'z-NPCaGCMhI6how5Ujj4udNfAnphLXNZ71IU_VGooRU'])],
            'OKP missing x' => [self::without(self::okpPublicKey(), 'x')],
            'OKP unsupported curve' => [self::okpPublicKey(['crv' => 'X25519'])],
            'OKP invalid x length' => [self::okpPublicKey(['x' => 'AQAB'])],
        ];
    }

    /**
     * @param array<string, mixed> $jwk
     */
    #[DataProvider('provideInvalidJwk')]
    public function testInvalidJwk(array $jwk): void
    {
        $this->expectException(JWKConverterException::class);
        $this->jwkConverter->toPEM($jwk);
    }

    /**
     * @return array<string, array{array<string, mixed>}>
     */
    public static function provideInvalidBase64(): array
    {
        return [
            'RSA n' => [self::rsaPublicKey(['n' => '!!!'])],
            'RSA e' => [self::rsaPublicKey(['e' => '!!!'])],
            'EC x' => [self::ecPublicKey(['x' => '!!!'])],
            'EC y' => [self::ecPublicKey(['y' => '!!!'])],
            'OKP x' => [self::okpPublicKey(['x' => '!!!'])],
        ];
    }

    /**
     * @param array<string, mixed> $jwk
     */
    #[DataProvider('provideInvalidBase64')]
    public function testInvalidBase64(array $jwk): void
    {
        $this->expectException(Base64DecodeException::class);
        $this->jwkConverter->toPEM($jwk);
    }
}
