<?php
/**
 * Dynamic Sitemap XML Generator
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=utf-8');

$siteUrl = getSetting('canonical_site_url', 'https://bharatseo.in');
$now = date('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Static pages
$staticPages = [
    ['url' => '', 'priority' => '1.0', 'freq' => 'weekly'],
    ['url' => '/about', 'priority' => '0.8', 'freq' => 'monthly'],
    ['url' => '/services', 'priority' => '0.9', 'freq' => 'weekly'],
    ['url' => '/industries', 'priority' => '0.9', 'freq' => 'weekly'],
    ['url' => '/packages', 'priority' => '0.8', 'freq' => 'monthly'],
    ['url' => '/portfolio', 'priority' => '0.7', 'freq' => 'weekly'],
    ['url' => '/case-studies', 'priority' => '0.7', 'freq' => 'weekly'],
    ['url' => '/blog', 'priority' => '0.8', 'freq' => 'daily'],
    ['url' => '/free-audit', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/contact', 'priority' => '0.8', 'freq' => 'monthly'],
    ['url' => '/privacy-policy', 'priority' => '0.3', 'freq' => 'yearly'],
    ['url' => '/terms-conditions', 'priority' => '0.3', 'freq' => 'yearly'],
    ['url' => '/disclaimer', 'priority' => '0.3', 'freq' => 'yearly'],
    ['url' => '/sitemap', 'priority' => '0.4', 'freq' => 'weekly'],
];

foreach ($staticPages as $page) {
    echo "<url>\n";
    echo "  <loc>{$siteUrl}{$page['url']}</loc>\n";
    echo "  <lastmod>{$now}</lastmod>\n";
    echo "  <changefreq>{$page['freq']}</changefreq>\n";
    echo "  <priority>{$page['priority']}</priority>\n";
    echo "</url>\n";
}

// Services
$services = getDB()->query("SELECT slug, updated_at FROM services WHERE is_active = 1")->fetchAll();
foreach ($services as $s) {
    $date = date('Y-m-d', strtotime($s['updated_at']));
    echo "<url>\n  <loc>{$siteUrl}/services/{$s['slug']}</loc>\n  <lastmod>{$date}</lastmod>\n  <changefreq>monthly</changefreq>\n  <priority>0.8</priority>\n</url>\n";
}

// Industries
$industries = getDB()->query("SELECT slug, updated_at FROM industries WHERE is_active = 1")->fetchAll();
foreach ($industries as $i) {
    $date = date('Y-m-d', strtotime($i['updated_at']));
    echo "<url>\n  <loc>{$siteUrl}/industries/{$i['slug']}</loc>\n  <lastmod>{$date}</lastmod>\n  <changefreq>monthly</changefreq>\n  <priority>0.8</priority>\n</url>\n";
}

// Case Studies
$cases = getDB()->query("SELECT slug, updated_at FROM case_studies WHERE is_active = 1")->fetchAll();
foreach ($cases as $c) {
    $date = date('Y-m-d', strtotime($c['updated_at']));
    echo "<url>\n  <loc>{$siteUrl}/case-studies/{$c['slug']}</loc>\n  <lastmod>{$date}</lastmod>\n  <changefreq>monthly</changefreq>\n  <priority>0.7</priority>\n</url>\n";
}

// Blog Posts
$posts = getDB()->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' AND publish_date <= NOW()")->fetchAll();
foreach ($posts as $p) {
    $date = date('Y-m-d', strtotime($p['updated_at']));
    echo "<url>\n  <loc>{$siteUrl}/blog/{$p['slug']}</loc>\n  <lastmod>{$date}</lastmod>\n  <changefreq>monthly</changefreq>\n  <priority>0.7</priority>\n</url>\n";
}

echo '</urlset>';
