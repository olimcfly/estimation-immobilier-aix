<?php

declare(strict_types=1);

$httpsIndicators = [
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    (($_SERVER['SERVER_PORT'] ?? null) === '443'),
    (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
    (($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '') === 'on'),
    (($_SERVER['HTTP_FRONT_END_HTTPS'] ?? '') === 'on'),
    (($_SERVER['REQUEST_SCHEME'] ?? '') === 'https'),
    (($_SERVER['HTTP_CF_VISITOR'] ?? '') !== '' && str_contains((string) $_SERVER['HTTP_CF_VISITOR'], '"https"')),
];

$isHttps = in_array(true, $httpsIndicators, true);

$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocalHost = str_starts_with($host, 'localhost') || str_starts_with($host, '127.0.0.1');

if (PHP_SAPI !== 'cli' && $host !== '' && !$isHttps && !$isLocalHost) {
    $target = 'https://' . $host . ($_SERVER['REQUEST_URI'] ?? '/');
    header('Location: ' . $target, true, 301);
    exit;
}

if (PHP_SAPI !== 'cli') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

    // CSP nonce is generated after bootstrap (below) so we defer CSP header.
    // See CSP header emission after bootstrap.
}

if (version_compare(PHP_VERSION, '8.0.0', '<')) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Configuration PHP invalide : cette application nécessite PHP 8.0+ (version détectée : ' . PHP_VERSION . ').';
    exit;
}

use App\Core\Config;
use App\Core\CspNonce;
use App\Core\Router;

require_once dirname(__DIR__) . '/app/core/bootstrap.php';

// Emit CSP header with per-request nonce (replaces unsafe-inline)
if (PHP_SAPI !== 'cli') {
    $nonce = CspNonce::get();
    $csp = implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "frame-ancestors 'none'",
        "form-action 'self'",
        "script-src 'self' 'nonce-{$nonce}'",
        "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com https://cdnjs.cloudflare.com",
        "style-src-attr 'unsafe-inline'",
        "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:",
        "img-src 'self' data: https:",
        "connect-src 'self'",
        "upgrade-insecure-requests",
    ]);
    header('Content-Security-Policy: ' . $csp);
}

$isMaintenanceEnabled = (bool) Config::get('maintenance.enabled', false);
$maintenanceAllowedPaths = Config::get('maintenance.allowed_paths', []);
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isAllowedPath = is_array($maintenanceAllowedPaths) && in_array($requestPath, $maintenanceAllowedPaths, true);

if ($isMaintenanceEnabled && !$isAllowedPath) {
    $retryAfter = max(60, (int) Config::get('maintenance.retry_after', 3600));
    header('Retry-After: ' . $retryAfter);
    http_response_code(503);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site en maintenance</title>
    <style>
        body { font-family: Arial, sans-serif; background: #faf9f7; color: #1a1410; margin: 0; display: grid; place-items: center; min-height: 100vh; }
        .card { background: #fff; border: 1px solid #e8dfd7; border-radius: 12px; padding: 2rem; max-width: 560px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); text-align: center; }
        h1 { margin-top: 0; color: #8B1538; }
        p { line-height: 1.6; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Maintenance en cours</h1>
        <p>Le site est momentanément indisponible pour une intervention technique.</p>
        <p>Merci de réessayer dans quelques instants.</p>
    </main>
</body>
</html>';
    exit;
}

$router = new Router();
require dirname(__DIR__) . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
