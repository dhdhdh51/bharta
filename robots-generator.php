<?php
/**
 * Dynamic Robots.txt Generator
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: text/plain; charset=utf-8');

$siteUrl = getSetting('canonical_site_url', 'https://bharatseo.in');

echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /admin/\n";
echo "Disallow: /includes/\n";
echo "Disallow: /config.php\n";
echo "Disallow: /database.sql\n";
echo "Disallow: /thank-you\n";
echo "\n";
echo "Sitemap: {$siteUrl}/sitemap.xml\n";
