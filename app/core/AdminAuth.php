<?php

declare(strict_types=1);

namespace App\Core;

final class AdminAuth
{
    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!empty($_SESSION['admin_authenticated']) && $_SESSION['admin_authenticated'] === true) {
            return true;
        }

        if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
            return true;
        }

        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            return ((string) ($_SESSION['user']['role'] ?? '')) === 'admin';
        }

        return false;
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            http_response_code(403);
            header('Content-Type: text/plain; charset=utf-8');
            echo '403 - Accès interdit. Authentification admin requise.';
            exit;
        }
    }

    public static function login(): void
    {
        $_SESSION['admin_authenticated'] = true;
    }

    public static function logout(): void
    {
        unset($_SESSION['admin_authenticated'], $_SESSION['is_admin'], $_SESSION['user']);
        session_destroy();
    }
}
