<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Cache;
use PHPUnit\Framework\TestCase;

final class CacheTest extends TestCase
{
    protected function setUp(): void
    {
        Cache::flush();
    }

    protected function tearDown(): void
    {
        Cache::flush();
    }

    public function testPutAndGet(): void
    {
        Cache::put('test_key', 'hello', 60);
        $this->assertSame('hello', Cache::get('test_key'));
    }

    public function testGetReturnsDefaultWhenMissing(): void
    {
        $this->assertNull(Cache::get('nonexistent'));
        $this->assertSame('default', Cache::get('nonexistent', 'default'));
    }

    public function testHas(): void
    {
        $this->assertFalse(Cache::has('test_key'));
        Cache::put('test_key', 'value', 60);
        $this->assertTrue(Cache::has('test_key'));
    }

    public function testForget(): void
    {
        Cache::put('test_key', 'value', 60);
        $this->assertTrue(Cache::has('test_key'));

        Cache::forget('test_key');
        $this->assertFalse(Cache::has('test_key'));
    }

    public function testRemember(): void
    {
        $callCount = 0;
        $callback = function () use (&$callCount) {
            $callCount++;
            return 'computed_value';
        };

        $result1 = Cache::remember('test_key', 60, $callback);
        $result2 = Cache::remember('test_key', 60, $callback);

        $this->assertSame('computed_value', $result1);
        $this->assertSame('computed_value', $result2);
        $this->assertSame(1, $callCount, 'Callback should only be called once');
    }

    public function testFlush(): void
    {
        Cache::put('key1', 'a', 60);
        Cache::put('key2', 'b', 60);

        Cache::flush();

        $this->assertFalse(Cache::has('key1'));
        $this->assertFalse(Cache::has('key2'));
    }

    public function testArrayValues(): void
    {
        $data = ['low' => 3800, 'mid' => 4200, 'high' => 4600];
        Cache::put('market_data', $data, 60);

        $this->assertSame($data, Cache::get('market_data'));
    }
}
