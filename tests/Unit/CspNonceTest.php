<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\CspNonce;
use PHPUnit\Framework\TestCase;

final class CspNonceTest extends TestCase
{
    public function testGetReturnsNonEmptyString(): void
    {
        $nonce = CspNonce::get();
        $this->assertNotEmpty($nonce);
    }

    public function testGetReturnsSameValuePerRequest(): void
    {
        $nonce1 = CspNonce::get();
        $nonce2 = CspNonce::get();
        $this->assertSame($nonce1, $nonce2);
    }

    public function testGetReturnsBase64String(): void
    {
        $nonce = CspNonce::get();
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9+\/=]+$/', $nonce);
    }

    public function testAttributeReturnsNonceAttribute(): void
    {
        $attr = CspNonce::attribute();
        $this->assertStringStartsWith('nonce="', $attr);
        $this->assertStringEndsWith('"', $attr);
    }
}
