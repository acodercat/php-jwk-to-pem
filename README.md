# php-jwk-to-pem
[![CI](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml/badge.svg)](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/acodercat/php-jwk-to-pem/branch/master/graph/badge.svg)](https://codecov.io/gh/acodercat/php-jwk-to-pem)
[![Total Downloads](https://poser.pugx.org/codercat/jwk-to-pem/downloads)](https://packagist.org/packages/codercat/jwk-to-pem)
[![License](https://poser.pugx.org/codercat/jwk-to-pem/license)](https://packagist.org/packages/codercat/jwk-to-pem)
[![Latest Stable Version](https://poser.pugx.org/codercat/jwk-to-pem/v/stable)](https://packagist.org/packages/codercat/jwk-to-pem)

Convert a public JSON Web Key (JWK) to PEM format.

Supported key types:

| `kty` | Curves (`crv`) |
|---|---|
| `RSA` | |
| `EC` | `P-256`, `P-384`, `P-521`, `secp256k1` |
| `OKP` | `Ed25519`, `Ed448` |

Only public keys are supported. A JWK containing private key material (`d`) is rejected.

## Installation

``` bash
composer require codercat/jwk-to-pem
```

## Usage

``` php
<?php

use CoderCat\JWKToPEM\JWKConverter;

$jwkConverter = new JWKConverter();

$jwk = [
    "kty" => "EC",
    "crv" => "P-256",
    "x" => "z-NPCaGCMhI6how5Ujj4udNfAnphLXNZ71IU_VGooRU",
    "y" => "-Ulv1IoijhEc9i2URAL8XRq8FKQ-HdKH0byaj3w0Moc",
];

$pem = $jwkConverter->toPEM($jwk);
```

The PEM for this JWK (lines are separated by `\r\n`):

```
-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEz+NPCaGCMhI6how5Ujj4udNfAnph
LXNZ71IU/VGooRX5SW/UiiKOERz2LZREAvxdGrwUpD4d0ofRvJqPfDQyhw==
-----END PUBLIC KEY-----
```

RSA keys work the same way, using the `n` and `e` parameters.

### Errors

- `CoderCat\JWKToPEM\Exception\JWKConverterException` is thrown when the JWK is missing a required parameter, has an unsupported key type or curve, contains a private key, or describes an invalid key.
- `CoderCat\JWKToPEM\Exception\Base64DecodeException` is thrown when a key parameter is not valid base64url.

## Development

``` bash
composer test      # run the test suite
composer analyse   # run PHPStan
```

## License

[MIT](LICENSE)
