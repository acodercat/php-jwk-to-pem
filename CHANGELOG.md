# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-11-23

### Added

- Support for EC public keys on the P-256, P-384, P-521 and secp256k1 curves.
- Support for OKP public keys on the Ed25519 and Ed448 curves.

### Changed

- **Breaking:** PHP 8.1 or later is required.
- **Breaking:** phpseclib `^4.0.4` is required, replacing phpseclib 3.
- **Breaking:** Errors raised by phpseclib while loading a key are now thrown as `JWKConverterException`.
- Exception messages now name the missing or invalid parameter.

### Removed

- **Breaking:** `JWKConverter::multipleToPEM()`. Call `toPEM()` for each key instead.

### Fixed

- The `e` parameter is now decoded as base64url. Values containing `-` or `_` were decoded incorrectly.
- Parameters that decode to `"0"` are no longer rejected as invalid base64.
- Non-string parameters now throw `JWKConverterException` instead of a `TypeError`.

## [1.1] - 2021-04-28

See the [GitHub release](https://github.com/acodercat/php-jwk-to-pem/releases/tag/1.1).

[2.0.0]: https://github.com/acodercat/php-jwk-to-pem/compare/1.1...2.0.0
[1.1]: https://github.com/acodercat/php-jwk-to-pem/releases/tag/1.1
