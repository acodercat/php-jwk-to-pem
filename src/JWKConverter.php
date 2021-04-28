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

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Math\BigInteger;
use CoderCat\JWKToPEM\Util\Base64UrlDecoder;
use CoderCat\JWKToPEM\Exception\JWKConverterException;

class JWKConverter
{

    /**
     * @param array $jwkSet
     * @return string[]
     * @throws JWKConverterException
     * @throws Exception\Base64DecodeException
     */
    public function multipleToPEM(array $jwkSet): array
    {
        $keys = [];

        foreach($jwkSet as $jwk) {
            if(!is_array($jwk)) {
                throw new JWKConverterException('`multipleToPEM` can only take in an array of JWKs.');
            }

            $keys[] = $this->toPEM($jwk);
        }

        return $keys;
    }

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

        if (array_key_exists('d', $jwk)) {
            throw new JWKConverterException('Public key is currently only supported.');
        }

        $base64UrlDecoder = new Base64UrlDecoder();

        return PublicKeyLoader::load([
            'e' => new BigInteger(base64_decode($jwk['e']), 256),
            'n' => new BigInteger($base64UrlDecoder->decode($jwk['n']), 256)
        ]);
    }

}
