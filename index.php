<?php
/**
 * Bharat SEO - Main Router
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/seo-helper.php';

$route = trim($_GET['route'] ?? '', '/');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/includes/form-handler.php';
}

// Route mapping
switch (true) {
    case $route === '' || $route === 'home':
        require __DIR__ . '/pages/home.php';
        break;
    case $route === 'about':
        require __DIR__ . '/pages/about.php';
        break;
    case $route === 'services':
        require __DIR__ . '/pages/services.php';
        break;
    case preg_match('#^services/([a-z0-9-]+)$#', $route, $m) === 1:
        $_GET['slug'] = $m[1];
        require __DIR__ . '/pages/service-detail.php';
        break;
    case $route === 'industries':
        require __DIR__ . '/pages/industries.php';
        break;
    case preg_match('#^industries/([a-z0-9-]+)$#', $route, $m) === 1:
        $_GET['slug'] = $m[1];
        require __DIR__ . '/pages/industry-detail.php';
        break;
    case $route === 'packages':
        require __DIR__ . '/pages/packages.php';
        break;
    case $route === 'portfolio':
        require __DIR__ . '/pages/portfolio.php';
        break;
    case $route === 'case-studies':
        require __DIR__ . '/pages/case-studies.php';
        break;
    case preg_match('#^case-studies/([a-z0-9-]+)$#', $route, $m) === 1:
        $_GET['slug'] = $m[1];
        require __DIR__ . '/pages/case-study-detail.php';
        break;
    case $route === 'free-audit':
        require __DIR__ . '/pages/free-audit.php';
        break;
    case $route === 'blog':
        require __DIR__ . '/pages/blog.php';
        break;
    case preg_match('#^blog/([a-z0-9-]+)$#', $route, $m) === 1:
        $_GET['slug'] = $m[1];
        require __DIR__ . '/pages/blog-post.php';
        break;
    case $route === 'contact':
        require __DIR__ . '/pages/contact.php';
        break;
    case $route === 'thank-you':
        require __DIR__ . '/pages/thank-you.php';
        break;
    case $route === 'privacy-policy':
        require __DIR__ . '/pages/privacy-policy.php';
        break;
    case $route === 'terms-conditions':
        require __DIR__ . '/pages/terms-conditions.php';
        break;
    case $route === 'disclaimer':
        require __DIR__ . '/pages/disclaimer.php';
        break;
    case $route === 'sitemap':
        require __DIR__ . '/pages/sitemap-page.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
        break;
}
