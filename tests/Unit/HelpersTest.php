<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

final class HelpersTest extends TestCase
{
    public function testEscapesHtml(): void
    {
        $this->assertSame('&lt;script&gt;', e('<script>'));
    }

    public function testEscapesQuotes(): void
    {
        $this->assertSame('&quot;hello&quot;', e('"hello"'));
    }

    public function testEscapesSingleQuotes(): void
    {
        $this->assertSame('l&#039;immobilier', e("l'immobilier"));
    }

    public function testBasePathReturnsProjectRoot(): void
    {
        $path = base_path();
        $this->assertDirectoryExists($path);
        $this->assertFileExists($path . '/composer.json');
    }

    public function testBasePathAppendsSubpath(): void
    {
        $path = base_path('config/config.php');
        $this->assertStringEndsWith('config/config.php', $path);
    }

    public function testHexToRgbConverts6CharHex(): void
    {
        $this->assertSame('0, 63, 135', hex_to_rgb('#003f87'));
    }

    public function testHexToRgbConverts3CharHex(): void
    {
        $this->assertSame('255, 255, 255', hex_to_rgb('#fff'));
    }

    public function testHexToRgbHandlesNoHash(): void
    {
        $this->assertSame('0, 0, 0', hex_to_rgb('000000'));
    }

    public function testHexToRgbReturnsBlackOnInvalid(): void
    {
        $this->assertSame('0, 0, 0', hex_to_rgb('invalid'));
    }
}
