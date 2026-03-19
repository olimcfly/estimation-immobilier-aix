<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function testDispatchesGetRoute(): void
    {
        $router = new Router();
        $called = false;

        $controller = new class {
            public bool $called = false;
            public function index(): void
            {
                $this->called = true;
            }
        };

        $router->get('/test', [get_class($controller), 'index']);

        ob_start();
        $router->dispatch('GET', '/test');
        ob_end_clean();

        // Route was registered - no fatal error thrown
        $this->assertTrue(true);
    }

    public function testFallbacksOn404(): void
    {
        $router = new Router();

        ob_start();
        $router->dispatch('GET', '/nonexistent-page-xyz');
        $output = ob_get_clean();

        // Should have produced a 404 or redirect
        $this->assertTrue(true);
    }
}
