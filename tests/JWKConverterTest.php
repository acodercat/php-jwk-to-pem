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

    /** @dataProvider provideMultipleToPem */
    public function testMultipleToPem($jwkSet, $expected)
    {
        print_r($this->jwkConverter->multipleToPem($jwkSet));
        $this->assertEquals($expected, $this->jwkConverter->multipleToPem($jwkSet));
    }

    public function provideMultipleToPem()
    {
        return [
            [
                [
                    [
                        'kty' => 'RSA',
                        'kid' => '86D88Kf',
                        'use' => 'sig',
                        'alg' => 'RS256',
                        'n' => 'iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ',
                        'e' => 'AQAB',
                    ],
                    [
                        'kty' => 'RSA',
                        'kid' => 'eXaunmL',
                        'use' => 'sig',
                        'alg' => 'RS256',
                        'n' => '4dGQ7bQK8LgILOdLsYzfZjkEAoQeVC_aqyc8GC6RX7dq_KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdDNq1n52TpxQwI2EqxSk7I9fKPKhRt4F8-2yETlYvye-2s6NeWJim0KBtOVrk0gWvEDgd6WOqJl_yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X-Tip84wqwyRpUlq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll-p_Dg8vAXxJLIJ4SNLcqgFeZe4OfHLgdzMvxXZJnPp_VgmkcpUdRotazKZumj6dBPcXI_XID4Z4Z3OM1KrZPJNdUhxw',
                        'e' => 'AQAB',
                    ],
                    [
                        'kty' => 'RSA',
                        'kid' => 'AIDOPK1',
                        'use' => 'sig',
                        'alg' => 'RS256',
                        'n' => 'lxrwmuYSAsTfn-lUu4goZSXBD9ackM9OJuwUVQHmbZo6GW4Fu_auUdN5zI7Y1dEDfgt7m7QXWbHuMD01HLnD4eRtY-RNwCWdjNfEaY_esUPY3OVMrNDI15Ns13xspWS3q-13kdGv9jHI28P87RvMpjz_JCpQ5IM44oSyRnYtVJO-320SB8E2Bw92pmrenbp67KRUzTEVfGU4-obP5RZ09OxvCr1io4KJvEOjDJuuoClF66AT72WymtoMdwzUmhINjR0XSqK6H0MdWsjw7ysyd_JhmqX5CAaT9Pgi0J8lU_pcl215oANqjy7Ob-VMhug9eGyxAWVfu_1u6QJKePlE-w',
                        'e' => 'AQAB',
                    ],
                ],
                [
                    "-----BEGIN PUBLIC KEY-----" . PHP_EOL
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiGaLqP6y+SJCCBq5Hv6p" . PHP_EOL
                    . "GDbG/SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInq" . PHP_EOL
                    . "UvjJur++hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPyg" . PHP_EOL
                    . "jLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk+ILjv1bORSRl" . PHP_EOL
                    . "8AK677+1T8isGfHKXGZ/ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl" . PHP_EOL
                    . "4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw+zHL" . PHP_EOL
                    . "wQIDAQAB" . PHP_EOL
                    . "-----END PUBLIC KEY-----",
                    "-----BEGIN PUBLIC KEY-----" . PHP_EOL
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4dGQ7bQK8LgILOdLsYzf" . PHP_EOL
                    . "ZjkEAoQeVC/aqyc8GC6RX7dq/KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdD" . PHP_EOL
                    . "Nq1n52TpxQwI2EqxSk7I9fKPKhRt4F8+2yETlYvye+2s6NeWJim0KBtOVrk0gWvE" . PHP_EOL
                    . " Dgd6WOqJl/yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X+Tip84wqwyRpU" . PHP_EOL
                    . "lq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll+p/Dg8vAXxJLIJ4SNLcqgFeZe" . PHP_EOL
                    . "4OfHLgdzMvxXZJnPp/VgmkcpUdRotazKZumj6dBPcXI/XID4Z4Z3OM1KrZPJNdUh" . PHP_EOL
                    . "xwIDAQAB" . PHP_EOL
                    . "-----END PUBLIC KEY-----",
                    "-----BEGIN PUBLIC KEY-----" . PHP_EOL
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlxrwmuYSAsTfn+lUu4go" . PHP_EOL
                    . "ZSXBD9ackM9OJuwUVQHmbZo6GW4Fu/auUdN5zI7Y1dEDfgt7m7QXWbHuMD01HLnD" . PHP_EOL
                    . "4eRtY+RNwCWdjNfEaY/esUPY3OVMrNDI15Ns13xspWS3q+13kdGv9jHI28P87RvM" . PHP_EOL
                    . "pjz/JCpQ5IM44oSyRnYtVJO+320SB8E2Bw92pmrenbp67KRUzTEVfGU4+obP5RZ0" . PHP_EOL
                    . "9OxvCr1io4KJvEOjDJuuoClF66AT72WymtoMdwzUmhINjR0XSqK6H0MdWsjw7ysy" . PHP_EOL
                    . "d/JhmqX5CAaT9Pgi0J8lU/pcl215oANqjy7Ob+VMhug9eGyxAWVfu/1u6QJKePlE" . PHP_EOL
                    . "+wIDAQAB" . PHP_EOL
                    . "-----END PUBLIC KEY-----"
                ]
            ]
        ];
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
