<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Models\Article;

final class SitemapController
{
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=3600');

        $baseUrl = rtrim((string) Config::get('base_url', ''), '/');

        $staticPages = [
            ['loc' => '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => '/estimation', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => '/services', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => '/a-propos', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => '/quartiers', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => '/blog', 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => '/guides', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => '/processus-estimation', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => '/exemples-estimation', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => '/calculatrice', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => '/podcast', 'changefreq' => 'weekly', 'priority' => '0.5'],
            ['loc' => '/newsletter', 'changefreq' => 'monthly', 'priority' => '0.4'],
            ['loc' => '/mentions-legales', 'changefreq' => 'yearly', 'priority' => '0.2'],
            ['loc' => '/politique-confidentialite', 'changefreq' => 'yearly', 'priority' => '0.2'],
            ['loc' => '/conditions-utilisation', 'changefreq' => 'yearly', 'priority' => '0.2'],
            ['loc' => '/rgpd', 'changefreq' => 'yearly', 'priority' => '0.2'],
        ];

        $articles = [];
        try {
            $articleModel = new Article();
            $articles = $articleModel->findPublished();
        } catch (\Throwable) {
            // Database may be unavailable
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($staticPages as $page) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $this->escapeXml($baseUrl . $page['loc']) . '</loc>' . "\n";
            $xml .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        foreach ($articles as $article) {
            $slug = $article['slug'] ?? '';
            if ($slug === '') {
                continue;
            }
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $this->escapeXml($baseUrl . '/blog/' . $slug) . '</loc>' . "\n";
            if (!empty($article['created_at'])) {
                $xml .= '    <lastmod>' . date('Y-m-d', strtotime((string) $article['created_at'])) . '</lastmod>' . "\n";
            }
            $xml .= '    <changefreq>monthly</changefreq>' . "\n";
            $xml .= '    <priority>0.6</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        echo $xml;
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
