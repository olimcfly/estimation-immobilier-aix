<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Simple file-based cache with TTL support.
 */
final class Cache
{
    private static ?string $cacheDir = null;

    public static function get(string $key, mixed $default = null): mixed
    {
        $path = self::path($key);

        if (!is_file($path)) {
            return $default;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            return $default;
        }

        $data = @unserialize($raw);
        if (!is_array($data) || !isset($data['expires_at'], $data['value'])) {
            @unlink($path);
            return $default;
        }

        if ($data['expires_at'] > 0 && time() > $data['expires_at']) {
            @unlink($path);
            return $default;
        }

        return $data['value'];
    }

    /**
     * Store a value in cache.
     *
     * @param int $ttl Time to live in seconds (0 = forever)
     */
    public static function put(string $key, mixed $value, int $ttl = 3600): void
    {
        self::ensureCacheDir();

        $data = [
            'expires_at' => $ttl > 0 ? time() + $ttl : 0,
            'value' => $value,
        ];

        $path = self::path($key);
        $tmp = $path . '.tmp.' . getmypid();

        if (file_put_contents($tmp, serialize($data), LOCK_EX) !== false) {
            rename($tmp, $path);
        }
    }

    public static function has(string $key): bool
    {
        return self::get($key, "\0__CACHE_MISS__\0") !== "\0__CACHE_MISS__\0";
    }

    public static function forget(string $key): void
    {
        $path = self::path($key);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Get or set: return cached value, or compute and store it.
     */
    public static function remember(string $key, int $ttl, callable $callback): mixed
    {
        $value = self::get($key);

        if ($value !== null) {
            return $value;
        }

        $value = $callback();
        self::put($key, $value, $ttl);

        return $value;
    }

    /**
     * Flush all cache files.
     */
    public static function flush(): void
    {
        $dir = self::cacheDir();
        if (!is_dir($dir)) {
            return;
        }

        $files = glob($dir . '/*.cache');
        if ($files === false) {
            return;
        }

        foreach ($files as $file) {
            @unlink($file);
        }
    }

    private static function path(string $key): string
    {
        return self::cacheDir() . '/' . md5($key) . '.cache';
    }

    private static function cacheDir(): string
    {
        if (self::$cacheDir === null) {
            self::$cacheDir = dirname(__DIR__, 2) . '/storage/cache';
        }

        return self::$cacheDir;
    }

    private static function ensureCacheDir(): void
    {
        $dir = self::cacheDir();
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
