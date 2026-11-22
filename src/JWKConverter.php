<?php

/*
 * This file is part of the codercat/jwk-to-pem package.
 *
 * (c) codercat <1067302838@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoderCat\JWKToPEM;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Exception\JWKConverterException;
use CoderCat\JWKToPEM\Util\Base64UrlDecoder;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Math\BigInteger;

class JWKConverter
{
    /**
     * Convert an RSA public JWK to a PEM encoded public key.
     *
     * @param array $jwk
     * @return string
     * @throws Base64DecodeException
     * @throws JWKConverterException
     */
    public function toPEM(array $jwk): string
    {
        foreach (['kty', 'n', 'e'] as $param) {
            if (!isset($jwk[$param]) || !is_string($jwk[$param])) {
                throw new JWKConverterException(sprintf('Missing or invalid "%s" parameter.', $param));
            }
        }

        if ($jwk['kty'] !== 'RSA') {
            throw new JWKConverterException('RSA key type is currently only supported.');
        }

        if (array_key_exists('d', $jwk)) {
            throw new JWKConverterException('Public key is currently only supported.');
        }

        $base64UrlDecoder = new Base64UrlDecoder();

        return (string) PublicKeyLoader::load([
            'e' => new BigInteger($base64UrlDecoder->decode($jwk['e']), 256),
            'n' => new BigInteger($base64UrlDecoder->decode($jwk['n']), 256),
        ]);
    }
}
