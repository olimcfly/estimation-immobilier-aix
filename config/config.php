<?php

declare(strict_types=1);

if (!defined('CITY_NAME')) {
    define('CITY_NAME', 'Lannion');
}
if (!defined('CITY_REGION')) {
    define('CITY_REGION', 'Bretagne');
}
if (!defined('CITY_CODE_POSTAL')) {
    define('CITY_CODE_POSTAL', '22300');
}
if (!defined('QUARTIERS')) {
    define('QUARTIERS', ['Centre-Ville', 'Trégor', 'Port', 'Brélévenez', 'Léguer']);
}
if (!defined('PRIX_M2_MOYEN')) {
    define('PRIX_M2_MOYEN', 3200);
}
if (!defined('COLOR_PRIMARY')) {
    define('COLOR_PRIMARY', '#003f87');
}
if (!defined('COLOR_SECONDARY')) {
    define('COLOR_SECONDARY', '#FFFFFF');
}
if (!defined('COLOR_ACCENT')) {
    define('COLOR_ACCENT', '#FFD700');
}

return [
    'app_name' => $_ENV['APP_NAME'] ?? 'Estimateur Immobilier SaaS',
    'base_url' => $_ENV['APP_BASE_URL'] ?? '',
    'website' => [
        'id' => (int) ($_ENV['WEBSITE_ID'] ?? 1),
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'name' => $_ENV['DB_NAME'] ?? 'immobilier_lannion',
        'user' => $_ENV['DB_USER'] ?? 'cool1933_lannion',
        'pass' => $_ENV['DB_PASS'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ],
    'perplexity' => [
        'api_key' => $_ENV['PERPLEXITY_API_KEY'] ?? '',
        'model' => $_ENV['PERPLEXITY_MODEL'] ?? 'sonar-pro',
        'endpoint' => $_ENV['PERPLEXITY_ENDPOINT'] ?? 'https://api.perplexity.ai/chat/completions',
    ],
    'mail' => [
        'from' => $_ENV['MAIL_FROM'] ?? 'no-reply@localhost',
    ],
    'openai' => [
        'api_key' => $_ENV['OPENAI_API_KEY'] ?? '',
        'model' => $_ENV['OPENAI_MODEL'] ?? 'gpt-4o-mini',
        'endpoint' => $_ENV['OPENAI_ENDPOINT'] ?? 'https://api.openai.com/v1/chat/completions',
    ],
    'city' => [
        'name' => CITY_NAME,
        'region' => CITY_REGION,
        'code_postal' => CITY_CODE_POSTAL,
        'quartiers' => QUARTIERS,
        'prix_m2_moyen' => PRIX_M2_MOYEN,
        'colors' => [
            'primary' => COLOR_PRIMARY,
            'secondary' => COLOR_SECONDARY,
            'accent' => COLOR_ACCENT,
        ],
    ],
    'site' => [
        'colors' => [
            'bg' => $_ENV['SITE_COLOR_BG'] ?? '#faf9f7',
            'surface' => $_ENV['SITE_COLOR_SURFACE'] ?? '#ffffff',
            'text' => $_ENV['SITE_COLOR_TEXT'] ?? '#1a1410',
            'muted' => $_ENV['SITE_COLOR_MUTED'] ?? '#6b6459',
            'primary' => $_ENV['SITE_COLOR_PRIMARY'] ?? '#8B1538',
            'primary_dark' => $_ENV['SITE_COLOR_PRIMARY_DARK'] ?? '#6b0f2d',
            'accent' => $_ENV['SITE_COLOR_ACCENT'] ?? '#D4AF37',
            'accent_light' => $_ENV['SITE_COLOR_ACCENT_LIGHT'] ?? '#E8C547',
            'border' => $_ENV['SITE_COLOR_BORDER'] ?? '#e8dfd7',
            'success' => $_ENV['SITE_COLOR_SUCCESS'] ?? '#22c55e',
            'warning' => $_ENV['SITE_COLOR_WARNING'] ?? '#f97316',
            'danger' => $_ENV['SITE_COLOR_DANGER'] ?? '#e24b4a',
            'info' => $_ENV['SITE_COLOR_INFO'] ?? '#3b82f6',
            'neutral' => $_ENV['SITE_COLOR_NEUTRAL'] ?? '#000000',
        ],
    ],
];
