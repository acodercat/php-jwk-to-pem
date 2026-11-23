# php-jwk-to-pem

[![CI](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml/badge.svg)](https://github.com/acodercat/php-jwk-to-pem/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/acodercat/php-jwk-to-pem/branch/master/graph/badge.svg)](https://codecov.io/gh/acodercat/php-jwk-to-pem)
[![Latest Version](https://img.shields.io/packagist/v/codercat/jwk-to-pem)](https://packagist.org/packages/codercat/jwk-to-pem)
[![PHP Version](https://img.shields.io/packagist/dependency-v/codercat/jwk-to-pem/php)](https://packagist.org/packages/codercat/jwk-to-pem)
[![Total Downloads](https://img.shields.io/packagist/dt/codercat/jwk-to-pem)](https://packagist.org/packages/codercat/jwk-to-pem)
[![License](https://img.shields.io/packagist/l/codercat/jwk-to-pem)](LICENSE)

Convert a public JSON Web Key (JWK) to a PEM encoded public key.

## Supported keys

| Key type (`kty`) | Curves (`crv`) |
|---|---|
| `RSA` | — |
| `EC` | `P-256`, `P-384`, `P-521`, `secp256k1` |
| `OKP` | `Ed25519`, `Ed448` |

Only public keys are supported. A JWK containing private key material (`d`) is rejected.

## Requirements

- PHP 8.1 or later

## Installation

```bash
composer require codercat/jwk-to-pem
```

## Usage

```php
use CoderCat\JWKToPEM\JWKConverter;

$converter = new JWKConverter();

$pem = $converter->toPEM([
    'kty' => 'EC',
    'crv' => 'P-256',
    'x' => 'z-NPCaGCMhI6how5Ujj4udNfAnphLXNZ71IU_VGooRU',
    'y' => '-Ulv1IoijhEc9i2URAL8XRq8FKQ-HdKH0byaj3w0Moc',
]);
```

`$pem` contains (lines are separated by `\r\n`):

```
-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEz+NPCaGCMhI6how5Ujj4udNfAnph
LXNZ71IU/VGooRX5SW/UiiKOERz2LZREAvxdGrwUpD4d0ofRvJqPfDQyhw==
-----END PUBLIC KEY-----
```

RSA keys work the same way, using the `n` and `e` parameters. Other JWK members such as `kid`, `use` and `alg` are ignored.

### Converting a key set (JWKS)

Identity providers usually publish their keys as a JWK Set. Convert each key and index the result by `kid`:

```php
$jwks = json_decode(file_get_contents('https://example.com/.well-known/jwks.json'), true);

$pems = [];
foreach ($jwks['keys'] as $jwk) {
    $pems[$jwk['kid']] = $converter->toPEM($jwk);
}
```

### Error handling

```php
use CoderCat\JWKToPEM\Exception\Base64DecodeException;
use CoderCat\JWKToPEM\Exception\JWKConverterException;

try {
    $pem = $converter->toPEM($jwk);
} catch (Base64DecodeException $e) {
    // A key parameter is not valid base64url.
} catch (JWKConverterException $e) {
    // A required parameter is missing, the key type or curve is not supported,
    // the JWK contains a private key, or the key itself is invalid.
}
```

## Upgrading from 1.x

Version 2.0 requires PHP 8.1 and phpseclib 4, and removes `JWKConverter::multipleToPEM()`. See the [changelog](CHANGELOG.md) for details.

## Development

```bash
composer test      # run the test suite
composer analyse   # run PHPStan
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

[MIT](LICENSE)
