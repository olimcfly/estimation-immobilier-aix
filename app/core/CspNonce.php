<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Generates and stores a per-request CSP nonce.
 */
final class CspNonce
{
    private static string $nonce = '';

    public static function get(): string
    {
        if (self::$nonce === '') {
            self::$nonce = base64_encode(random_bytes(16));
        }

        return self::$nonce;
    }

    public static function attribute(): string
    {
        return 'nonce="' . self::get() . '"';
    }
}
