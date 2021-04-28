<?php
namespace CoderCat\JWKToPEM\Tests;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Exception\JWKConverterException;
use CoderCat\JWKToPEM\JWKConverter;
use PHPUnit\Framework\TestCase;

class JWKConverterTest extends TestCase
{
    /** @var JWKConverter */
    private $jwkConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwkConverter = new JwkConverter();
    }

    /** @dataProvider provideToPEM
     * @param $jwk
     * @param $expected
     * @throws Base64DecodeException
     * @throws JWKConverterException
     */
    public function testToPEM($jwk, $expected)
    {
        $this->assertEquals($expected, $this->jwkConverter->toPEM($jwk));
    }

    public function provideToPEM(): array
    {
        return [
            [
                [
                    "kty" => "RSA",
                    "kid" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
                    "use" => "sig",
                    "alg" => "RS256",
                    "e" => "AQAB",
                    "n" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
                ],
                "-----BEGIN PUBLIC KEY-----\r\n"
                . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p\r\n"
                . "VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw\r\n"
                . "SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd\r\n"
                . "9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x\r\n"
                . "o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x\r\n"
                . "yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz\r\n"
                . "BwIDAQAB\r\n"
                . "-----END PUBLIC KEY-----"
            ]
        ];
    }

    public function provideNotSupportedKeyType(): array
    {
        return [
            [
                [
                    "kty" => "NSA",
                    "kid" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
                    "use" => "sig",
                    "alg" => "RS256",
                    "e" => "AQAB",
                    "n" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
                ]
            ]
        ];
    }

    /** @dataProvider provideNotSupportedKeyType
     * @param $jwk
     * @throws Base64DecodeException
     */
    public function testNotSupportedKeyType($jwk)
    {
        $this->expectException(JWKConverterException::class);
        $this->jwkConverter->toPEM($jwk);
    }

    public function provideNonPublicKey(): array
    {
        return [
            [
                [
                    "kty" => "NSA",
                    "kid" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
                    "use" => "sig",
                    "alg" => "RS256",
                    "e" => "AQAB",
                    "c" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
                ]
            ]
        ];
    }

    /** @dataProvider provideNonPublicKey
     * @param $jwk
     * @throws Base64DecodeException
     */
    public function testNonPublicKey($jwk)
    {
        $this->expectException(JWKConverterException::class);
        $this->jwkConverter->toPEM($jwk);
    }

    public function provideWrongPublicKey(): array
    {
        return [
            [
                [
                    "kty1" => "NSA",
                    "k1id" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
                    "us1e" => "sig",
                    "al1g" => "RS256",
                    "ee" => "AQAB",
                    "c1" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
                ]
            ]
        ];
    }

    /** @dataProvider provideWrongPublicKey
     * @param $jwk
     * @throws Base64DecodeException
     */
    public function testWrongPublicKey($jwk)
    {
        $this->expectException(JWKConverterException::class);
        $this->jwkConverter->toPEM($jwk);
    }

}