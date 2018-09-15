<?php

/*
 * This file is part of the JwkFromOidcToken package.
 *
 * (c) codercat <1067302838@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoderCat\JWKToPEM\Util;

use CoderCat\JWKToPEM\Exception\Base64DecodeException;

class Base64UrlDecoder
{
    /**
     * @param string $str
     * @return string
     * @throws Base64DecodeException
     */
    public function decode(string $str): string
    {
        $decoded = base64_decode(strtr($str, '-_', '+/'), true);
        if (!$decoded) {
            throw new Base64DecodeException();
        }
        return $decoded;
    }
}