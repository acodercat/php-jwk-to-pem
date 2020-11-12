# php-jwk-to-pem
[![Build Status](https://travis-ci.org/acodercat/php-jwk-to-pem.svg?branch=master)](https://travis-ci.org/acodercat/php-jwk-to-pem)
[![codecov](https://codecov.io/gh/acodercat/php-jwk-to-pem/branch/master/graph/badge.svg)](https://codecov.io/gh/acodercat/php-jwk-to-pem)
[![Total Downloads](https://poser.pugx.org/codercat/jwk-to-pem/downloads)](https://packagist.org/packages/codercat/jwk-to-pem)
[![License](https://poser.pugx.org/codercat/jwk-to-pem/license)](https://packagist.org/packages/codercat/jwk-to-pem)
[![Latest Stable Version](https://poser.pugx.org/codercat/jwk-to-pem/v/stable)](https://packagist.org/packages/codercat/jwk-to-pem)

Convert JSON Web Key (JWK) to PEM format.

**NOTICE:** RSA key type is currently only supported.

## Installation

``` bash
composer require codercat/jwk-to-pem
```

## Test

``` bash
vendor/bin/phpunit
```

## Usage

#### Single JWK

``` php
<?php

use CoderCat\JWKToPEM\JWKConverter;

$jwkConverter = new JWKConverter();

// !!!! RSA key type is currently only supported.
$JWK = [
    "kty" => "RSA",
    "kid" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
    "use" => "sig",
    "alg" => "RS256",
    "e" => "AQAB",
    "n" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
];

```
Convert to PEM:

``` php
$PEM = $jwkConverter->toPEM($JWK);
```
The PEM for this JWK:

```
-----BEGIN PUBLIC KEY-----\r\n
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p\r\n
VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw\r\n
SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd\r\n
9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x\r\n
o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x\r\n
yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz\r\n
BwIDAQAB\r\n
-----END PUBLIC KEY-----
```
#### Multiple JWK
You can also convert multiple JWKs by using `multipleToPEM`:
``` php
<?php

use CoderCat\JWKToPEM\JWKConverter;

$jwkConverter = new JWKConverter();

// !!!! RSA key type is currently only supported.
$JWKs = [
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
];
```

Convert to PEMs:

``` php
$PEMs = $jwkConverter->multipleToPEM($JWKs);
```
The PEMs for this JWKs:
``` php
[
    "-----BEGIN PUBLIC KEY-----\r\n
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiGaLqP6y+SJCCBq5Hv6p\r\n
    GDbG/SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInq\r\n
    UvjJur++hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPyg\r\n
    jLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk+ILjv1bORSRl\r\n
    8AK677+1T8isGfHKXGZ/ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl\r\n
    4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw+zHL\r\n
    wQIDAQAB\r\n
    -----END PUBLIC KEY-----",
    "-----BEGIN PUBLIC KEY-----\r\n
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4dGQ7bQK8LgILOdLsYzf\r\n
    ZjkEAoQeVC/aqyc8GC6RX7dq/KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdD\r\n
    Nq1n52TpxQwI2EqxSk7I9fKPKhRt4F8+2yETlYvye+2s6NeWJim0KBtOVrk0gWvE\r\n
    Dgd6WOqJl/yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X+Tip84wqwyRpU\r\n
    lq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll+p/Dg8vAXxJLIJ4SNLcqgFeZe\r\n
    4OfHLgdzMvxXZJnPp/VgmkcpUdRotazKZumj6dBPcXI/XID4Z4Z3OM1KrZPJNdUh\r\n
    xwIDAQAB\r\n
    -----END PUBLIC KEY-----",
]
```


## License

[MIT](LICENSE)
