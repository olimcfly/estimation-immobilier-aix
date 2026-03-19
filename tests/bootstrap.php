<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/core/helpers.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (str_starts_with($class, $prefix)) {
        $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
        $segments = explode('/', $relative);
        if (isset($segments[0])) {
            $segments[0] = strtolower($segments[0]);
        }
        $file = __DIR__ . '/../app/' . implode('/', $segments) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }

    $prefix = 'Tests\\';
    if (str_starts_with($class, $prefix)) {
        $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
        $file = __DIR__ . '/' . $relative . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});
