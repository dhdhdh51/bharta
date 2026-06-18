<?php
/**
 * SEO Helper - Generates meta tags, schema, Open Graph and Twitter cards
 */

function renderSeoHead(array $seo, array $overrides = []): string {
    $title = $overrides['meta_title'] ?? $seo['meta_title'] ?? getSetting('default_meta_title');
    $description = $overrides['meta_description'] ?? $seo['meta_description'] ?? getSetting('default_meta_description');
    $keywords = $overrides['meta_keywords'] ?? $seo['meta_keywords'] ?? getSetting('default_meta_keywords');
    $canonical = $overrides['canonical_url'] ?? $seo['canonical_url'] ?? getCurrentUrl();
    $robots = $overrides['robots_meta'] ?? $seo['robots_meta'] ?? 'index, follow';
    $ogTitle = $seo['og_title'] ?? $title;
    $ogDesc = $seo['og_description'] ?? $description;
    $ogImage = $seo['og_image'] ?? getSetting('logo');
    $twitterTitle = $seo['twitter_title'] ?? $ogTitle;
    $twitterDesc = $seo['twitter_description'] ?? $ogDesc;
    $twitterImage = $seo['twitter_image'] ?? $ogImage;
    $siteUrl = getSetting('canonical_site_url', SITE_URL);

    $html = '';
    $html .= '<title>' . sanitize($title) . '</title>' . "\n";
    $html .= '<meta name="description" content="' . sanitize($description) . '">' . "\n";
    if ($keywords) {
        $html .= '<meta name="keywords" content="' . sanitize($keywords) . '">' . "\n";
    }
    $html .= '<meta name="robots" content="' . sanitize($robots) . '">' . "\n";
    $html .= '<link rel="canonical" href="' . sanitize($canonical) . '">' . "\n";

    // Open Graph
    $html .= '<meta property="og:type" content="website">' . "\n";
    $html .= '<meta property="og:title" content="' . sanitize($ogTitle) . '">' . "\n";
    $html .= '<meta property="og:description" content="' . sanitize($ogDesc) . '">' . "\n";
    $html .= '<meta property="og:url" content="' . sanitize($canonical) . '">' . "\n";
    if ($ogImage) {
        $imgUrl = (strpos($ogImage, 'http') === 0) ? $ogImage : $siteUrl . $ogImage;
        $html .= '<meta property="og:image" content="' . sanitize($imgUrl) . '">' . "\n";
    }
    $html .= '<meta property="og:site_name" content="' . sanitize(getSetting('agency_name', SITE_NAME)) . '">' . "\n";

    // Twitter Card
    $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $html .= '<meta name="twitter:title" content="' . sanitize($twitterTitle) . '">' . "\n";
    $html .= '<meta name="twitter:description" content="' . sanitize($twitterDesc) . '">' . "\n";
    if ($twitterImage) {
        $imgUrl = (strpos($twitterImage, 'http') === 0) ? $twitterImage : $siteUrl . $twitterImage;
        $html .= '<meta name="twitter:image" content="' . sanitize($imgUrl) . '">' . "\n";
    }

    // Custom header scripts
    if (!empty($seo['custom_header_scripts'])) {
        $html .= $seo['custom_header_scripts'] . "\n";
    }

    return $html;
}

/**
 * Render Schema JSON-LD
 */
function renderSchema(array $seo, array $additionalSchema = []): string {
    $html = '';

    // Page-specific schema from admin
    if (!empty($seo['schema_json'])) {
        $html .= '<script type="application/ld+json">' . $seo['schema_json'] . '</script>' . "\n";
    }

    // Additional schemas
    foreach ($additionalSchema as $schema) {
        $html .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }

    return $html;
}

/**
 * Generate LocalBusiness Schema
 */
function getLocalBusinessSchema(): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => getSetting('agency_name', 'Bharat SEO'),
        'description' => getSetting('default_meta_description'),
        'url' => getSetting('canonical_site_url', SITE_URL),
        'telephone' => getSetting('phone'),
        'email' => getSetting('email'),
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'IN',
            'addressLocality' => getSetting('address', 'India'),
        ],
        'openingHours' => getSetting('business_hours'),
        'sameAs' => array_filter([
            getSetting('instagram_url'),
            getSetting('facebook_url'),
            getSetting('linkedin_url'),
            getSetting('youtube_url'),
        ]),
    ];
}

/**
 * Generate BreadcrumbList Schema
 */
function getBreadcrumbSchema(array $items): array {
    $listItems = [];
    foreach ($items as $i => $item) {
        $listItems[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'] ?? '',
        ];
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $listItems,
    ];
}

/**
 * Generate FAQ Schema
 */
function getFaqSchema(array $faqs): array {
    $items = [];
    foreach ($faqs as $faq) {
        $items[] = [
            '@type' => 'Question',
            'name' => $faq['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['a'],
            ],
        ];
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items,
    ];
}

/**
 * Render footer scripts
 */
function renderFooterScripts(array $seo): string {
    $html = '';
    if (!empty($seo['custom_footer_scripts'])) {
        $html .= $seo['custom_footer_scripts'] . "\n";
    }
    // Google Analytics
    $ga = getSetting('google_analytics');
    if ($ga) {
        $html .= $ga . "\n";
    }
    // Meta Pixel
    $pixel = getSetting('meta_pixel');
    if ($pixel) {
        $html .= $pixel . "\n";
    }
    return $html;
}
