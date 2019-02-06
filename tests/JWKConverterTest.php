<?php
namespace CoderCat\JWKToPEM\Tests;

use CoderCat\JWKToPEM\JWKConverter;
use PHPUnit\Framework\TestCase;

class JWKConverterTest extends TestCase
{
    /** @var JWKConverter */
    private $jwkConverter;

    protected function setUp()
    {
        parent::setUp();
        $this->jwkConverter = new JwkConverter();
    }

    /** @dataProvider provideToPem */
    public function testToPem($jwk, $expected)
    {
        $this->assertEquals($expected, $this->jwkConverter->toPem($jwk));
    }

    public function provideToPem()
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
                "-----BEGIN PUBLIC KEY-----" . PHP_EOL
                . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p" . PHP_EOL
                . "VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw" . PHP_EOL
                . "SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd" . PHP_EOL
                . "9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x" . PHP_EOL
                . "o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x" . PHP_EOL
                . "yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz" . PHP_EOL
                . "BwIDAQAB" . PHP_EOL
                . "-----END PUBLIC KEY-----"
            ]
        ];
    }
}
