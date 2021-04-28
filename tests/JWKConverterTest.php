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

    /** @dataProvider provideMultipleToPEM
     * @param $jwkSet
     * @param $expected
     * @throws Base64DecodeException
     * @throws JWKConverterException
     */
    public function testMultipleToPEM($jwkSet, $expected)
    {
        $this->assertEquals($expected, $this->jwkConverter->multipleToPEM($jwkSet));
    }

    public function provideMultipleToPEM(): array
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
                    "-----BEGIN PUBLIC KEY-----\r\n"
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiGaLqP6y+SJCCBq5Hv6p\r\n"
                    . "GDbG/SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInq\r\n"
                    . "UvjJur++hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPyg\r\n"
                    . "jLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk+ILjv1bORSRl\r\n"
                    . "8AK677+1T8isGfHKXGZ/ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl\r\n"
                    . "4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw+zHL\r\n"
                    . "wQIDAQAB\r\n"
                    . "-----END PUBLIC KEY-----",
                    "-----BEGIN PUBLIC KEY-----\r\n"
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4dGQ7bQK8LgILOdLsYzf\r\n"
                    . "ZjkEAoQeVC/aqyc8GC6RX7dq/KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdD\r\n"
                    . "Nq1n52TpxQwI2EqxSk7I9fKPKhRt4F8+2yETlYvye+2s6NeWJim0KBtOVrk0gWvE\r\n"
                    . "Dgd6WOqJl/yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X+Tip84wqwyRpU\r\n"
                    . "lq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll+p/Dg8vAXxJLIJ4SNLcqgFeZe\r\n"
                    . "4OfHLgdzMvxXZJnPp/VgmkcpUdRotazKZumj6dBPcXI/XID4Z4Z3OM1KrZPJNdUh\r\n"
                    . "xwIDAQAB\r\n"
                    . "-----END PUBLIC KEY-----",
                    "-----BEGIN PUBLIC KEY-----\r\n"
                    . "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlxrwmuYSAsTfn+lUu4go\r\n"
                    . "ZSXBD9ackM9OJuwUVQHmbZo6GW4Fu/auUdN5zI7Y1dEDfgt7m7QXWbHuMD01HLnD\r\n"
                    . "4eRtY+RNwCWdjNfEaY/esUPY3OVMrNDI15Ns13xspWS3q+13kdGv9jHI28P87RvM\r\n"
                    . "pjz/JCpQ5IM44oSyRnYtVJO+320SB8E2Bw92pmrenbp67KRUzTEVfGU4+obP5RZ0\r\n"
                    . "9OxvCr1io4KJvEOjDJuuoClF66AT72WymtoMdwzUmhINjR0XSqK6H0MdWsjw7ysy\r\n"
                    . "d/JhmqX5CAaT9Pgi0J8lU/pcl215oANqjy7Ob+VMhug9eGyxAWVfu/1u6QJKePlE\r\n"
                    . "+wIDAQAB\r\n"
                    . "-----END PUBLIC KEY-----"
                ]
            ]
        ];
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

    public function provideToPEM()
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
}
