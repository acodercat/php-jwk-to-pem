# php-jwk-to-pem

Convert JWK to PEM format.

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
$jwk = [
    "kty" => "RSA",
    "kid" => "zhA-H1DWOSgWQAIW7mewCYeaZLGpkgW_hXfq8jmV99I",
    "use" => "sig",
    "alg" => "RS256",
    "e" => "AQAB",
    "n" => "vdv73smpkrTIBSM8ka-pVXbNi7zYalm0R6WFBH4X8PQj8C7VfdckGsA6bTBseOVCTbu187_63yU2U7vqYiqwSLmkrBVAJjYMJY_XXfncxwqDWR_aa7eIJSKh22H_6yz6kFyF1h_ZSk68CPAEQpvd9VFAr4VLEwD32Ag6MwymSOxmFWJyddEtttdGcXLSrHcya3RWyG5KAW3Ti-HgNC-xo_C5LgEsUgjeUq-rc8NBXZrNCY-LJ_R-qtB_-5NkwlMJ_fUMBDcmZuciNOH71q7xyn0FGmGjrJXnyVJwyDiTrKRO36piMuiaJE2nIRJaLvhDN5M1K2VhSKPuaqUPyxLzBw"
];

```
Convert to PEM format:

``` php
$convertedJwk = $jwkConverter->toPEM($jwk);
echo $convertedJwk;
```

The PEM for this jwk:

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

