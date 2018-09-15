<?php

/*
 * This file is part of the JwkFromOidcToken package.
 *
 * (c) codercat <1067302838@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoderCat\JWKToPEM\Exception;


class JWKConverterException  extends \Exception
{
    protected $message = 'This JWK cannot be converted to PEM format.';
}