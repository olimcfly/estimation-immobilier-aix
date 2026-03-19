<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Validator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testStringReturnsValidValue(): void
    {
        $result = Validator::string(['name' => 'Jean Dupont'], 'name');
        $this->assertSame('Jean Dupont', $result);
    }

    public function testStringTrimsWhitespace(): void
    {
        $result = Validator::string(['name' => '  Jean  '], 'name');
        $this->assertSame('Jean', $result);
    }

    public function testStringThrowsOnEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::string(['name' => ''], 'name');
    }

    public function testStringThrowsOnMissingKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::string([], 'name');
    }

    public function testStringThrowsOnTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::string(['name' => 'ab'], 'name', 5);
    }

    public function testStringThrowsOnTooLong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::string(['name' => 'abcdef'], 'name', 1, 3);
    }

    public function testFloatReturnsValidValue(): void
    {
        $result = Validator::float(['price' => '85.5'], 'price');
        $this->assertSame(85.5, $result);
    }

    public function testFloatThrowsOnInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::float(['price' => 'abc'], 'price');
    }

    public function testFloatThrowsOnBelowMin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::float(['price' => '0.01'], 'price', 1.0);
    }

    public function testIntReturnsValidValue(): void
    {
        $result = Validator::int(['rooms' => '3'], 'rooms');
        $this->assertSame(3, $result);
    }

    public function testIntThrowsOnNonInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::int(['rooms' => '3.5'], 'rooms');
    }

    public function testIntThrowsOnBelowMin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::int(['rooms' => '0'], 'rooms');
    }

    public function testEmailReturnsValidEmail(): void
    {
        $result = Validator::email(['email' => 'test@example.com'], 'email');
        $this->assertSame('test@example.com', $result);
    }

    public function testEmailThrowsOnInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::email(['email' => 'not-an-email'], 'email');
    }

    public function testEmailThrowsOnEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Validator::email(['email' => ''], 'email');
    }
}
