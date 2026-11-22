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

class JWKConverter
{
    /**
     * Public key parameters required for each supported key type (RFC 7518, RFC 8037).
     */
    private const REQUIRED_PARAMETERS = [
        'RSA' => ['n', 'e'],
        'EC' => ['crv', 'x', 'y'],
        'OKP' => ['crv', 'x'],
    ];

    /**
     * Public key sizes in bytes for the supported OKP curves (RFC 8032).
     */
    private const OKP_KEY_SIZES = [
        'Ed25519' => 32,
        'Ed448' => 57,
    ];

    /** @var Base64UrlDecoder */
    private $base64UrlDecoder;

    public function __construct()
    {
        $this->base64UrlDecoder = new Base64UrlDecoder();
    }

    /**
     * Convert a public JWK (RSA, EC or OKP) to a PEM encoded public key.
     *
     * @param array<string, mixed> $jwk
     * @return string
     * @throws Base64DecodeException
     * @throws JWKConverterException
     */
    public function toPEM(array $jwk): string
    {
        $json = json_encode($this->buildPublicJwk($jwk));

        if ($json === false) {
            throw new JWKConverterException('Unable to encode the JWK.');
        }

        try {
            $key = PublicKeyLoader::loadPublicKey($json);
        } catch (\Exception $e) {
            throw new JWKConverterException(sprintf('Unable to load the key: %s', $e->getMessage()), 0, $e);
        }

        $pem = $key->toString('PKCS8');

        if (!is_string($pem)) {
            throw new JWKConverterException('Unable to export the key as PEM.');
        }

        return $pem;
    }

    /**
     * Validate the JWK and return only its public key parameters, with binary
     * values re-encoded as canonical (unpadded) base64url.
     *
     * @param array<string, mixed> $jwk
     * @return array<string, string>
     * @throws Base64DecodeException
     * @throws JWKConverterException
     */
    private function buildPublicJwk(array $jwk): array
    {
        $keyType = $this->getStringParameter($jwk, 'kty');

        if (!isset(self::REQUIRED_PARAMETERS[$keyType])) {
            throw new JWKConverterException(sprintf('Unsupported key type "%s".', $keyType));
        }

        if (array_key_exists('d', $jwk)) {
            throw new JWKConverterException('Only public keys are supported.');
        }

        $publicJwk = ['kty' => $keyType];

        foreach (self::REQUIRED_PARAMETERS[$keyType] as $name) {
            $value = $this->getStringParameter($jwk, $name);

            if ($name === 'crv') {
                $publicJwk[$name] = $value;
                continue;
            }

            $decoded = $this->base64UrlDecoder->decode($value);

            if ($keyType === 'OKP') {
                $this->assertOkpKeySize($this->getStringParameter($jwk, 'crv'), $decoded);
            }

            $publicJwk[$name] = rtrim(strtr(base64_encode($decoded), '+/', '-_'), '=');
        }

        return $publicJwk;
    }

    /**
     * phpseclib does not check the length of OKP public keys, so do it here.
     *
     * @param string $curve
     * @param string $publicKey
     * @throws JWKConverterException
     */
    private function assertOkpKeySize(string $curve, string $publicKey): void
    {
        if (!isset(self::OKP_KEY_SIZES[$curve])) {
            throw new JWKConverterException(sprintf('Unsupported curve "%s".', $curve));
        }

        if (strlen($publicKey) !== self::OKP_KEY_SIZES[$curve]) {
            throw new JWKConverterException(sprintf('Invalid public key size for curve "%s".', $curve));
        }
    }

    /**
     * @param array<string, mixed> $jwk
     * @param string $name
     * @return string
     * @throws JWKConverterException
     */
    private function getStringParameter(array $jwk, string $name): string
    {
        if (!isset($jwk[$name]) || !is_string($jwk[$name])) {
            throw new JWKConverterException(sprintf('Missing or invalid "%s" parameter.', $name));
        }

        return $jwk[$name];
    }
}
