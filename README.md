# php-jwk-to-pem
[![CI](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml/badge.svg)](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml)
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

## Usage

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
The PEM for this JWK (lines are separated by `\r\n`):

```
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvdv73smpkrTIBSM8ka+p
VXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187/63yU2U7vqYiqw
SLmkrBVAJjYMJY/XXfncxwqDWR/aa7eIJSKh22H/6yz6kFyF1h/ZSk68CPAEQpvd
9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti+HgNC+x
o/C5LgEsUgjeUq+rc8NBXZrNCY+LJ/R+qtB/+5NkwlMJ/fUMBDcmZuciNOH71q7x
yn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLz
BwIDAQAB
-----END PUBLIC KEY-----
```

## Test

``` bash
composer test
```

## License

[MIT](LICENSE)
