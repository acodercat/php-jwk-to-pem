<?php

/*
 * This file is part of the JwkFromOidcToken package.
 *
 * (c) codercat <1067302838@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoderCat\JWKToPEM;

use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;
use CoderCat\JWKToPEM\Util\Base64UrlDecoder;
use CoderCat\JWKToPEM\Exception\JWKConverterException;

class JWKConverter
{

    /**
     * @param array $jwk
     * @return string
     * @throws Exception\Base64DecodeException
     * @throws JWKConverterException
     */
    public function toPEM(array $jwk): string
    {
        if (!array_key_exists('e', $jwk) || !array_key_exists('n', $jwk) || !array_key_exists('kty', $jwk)) {
            throw new JWKConverterException();
        }

        if ($jwk['kty'] != 'RSA') {
            throw new JWKConverterException('RSA key type is currently only supported.');
        }

        $rsa = new RSA();
        $base64UrlDecoder = new Base64UrlDecoder();
        $rsa->loadKey(
            [
                'e' => new BigInteger(base64_decode($jwk['e']), 256),
                'n' => new BigInteger($base64UrlDecoder->decode($jwk['n']), 256)
            ]
        );
        return $rsa->getPublicKey();
    }

}