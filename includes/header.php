<?php
/**
 * Bharat SEO - Header Template
 */
$agencyName = getSetting('agency_name', 'Bharat SEO');
$phone = getSetting('phone', '+91-XXXXXXXXXX');
$whatsapp = getSetting('whatsapp', '+91-XXXXXXXXXX');
$whatsappClean = preg_replace('/[^0-9]/', '', $whatsapp);
$primaryColor = getSetting('primary_color', '#071D49');
$secondaryColor = getSetting('secondary_color', '#FF8A00');
$accentColor = getSetting('accent_color', '#1B66FF');
$logo = getSetting('logo', '/assets/images/logo.png');
$favicon = getSetting('favicon', '/assets/images/favicon.png');
$scVerification = getSetting('search_console_verification');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if ($scVerification): ?>
    <meta name="google-site-verification" content="<?= sanitize($scVerification) ?>">
    <?php endif; ?>
    <?php echo renderSeoHead($pageSeo ?? [], $seoOverrides ?? []); ?>
    <link rel="icon" type="image/png" href="<?= sanitize($favicon) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        :root {
            --color-primary: <?= sanitize($primaryColor) ?>;
            --color-secondary: <?= sanitize($secondaryColor) ?>;
            --color-accent: <?= sanitize($accentColor) ?>;
        }
    </style>
    <?php echo renderSchema($pageSeo ?? [], $pageSchemas ?? []); ?>
</head>
<body>
    <!-- Skip Navigation -->
    <a href="#main-content" class="skip-nav">Skip to main content</a>

    <!-- Header -->
    <header class="site-header" id="site-header">
        <div class="container header-inner">
            <a href="/" class="logo" aria-label="<?= sanitize($agencyName) ?> - Home">
                <span class="logo-text"><?= sanitize($agencyName) ?></span>
            </a>

            <nav class="main-nav" id="main-nav" aria-label="Main Navigation">
                <ul class="nav-list">
                    <li><a href="/" class="<?= isActivePage('') && !isset($_GET['route']) ? 'active' : '' ?>">Home</a></li>
                    <li><a href="/services" class="<?= isActivePage('services') ? 'active' : '' ?>">Services</a></li>
                    <li><a href="/industries" class="<?= isActivePage('industries') ? 'active' : '' ?>">Industries</a></li>
                    <li><a href="/packages" class="<?= isActivePage('packages') ? 'active' : '' ?>">Packages</a></li>
                    <li><a href="/portfolio" class="<?= isActivePage('portfolio') ? 'active' : '' ?>">Portfolio</a></li>
                    <li><a href="/blog" class="<?= isActivePage('blog') ? 'active' : '' ?>">Blog</a></li>
                    <li><a href="/contact" class="<?= isActivePage('contact') ? 'active' : '' ?>">Contact</a></li>
                </ul>
            </nav>

            <a href="/free-audit" class="btn btn-primary header-cta">Get Free Audit</a>

            <button class="mobile-toggle" id="mobile-toggle" aria-label="Open menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobile-nav" aria-hidden="true">
        <div class="mobile-nav-inner">
            <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">&times;</button>
            <ul class="mobile-nav-list">
                <li><a href="/">Home</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/industries">Industries</a></li>
                <li><a href="/packages">Packages</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/free-audit" class="btn btn-primary">Get Free Audit</a></li>
            </ul>
        </div>
    </div>

    <!-- Mobile Bottom Bar -->
    <div class="mobile-bottom-bar">
        <a href="tel:<?= sanitize($phone) ?>" class="mobile-bar-btn mobile-bar-call">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            Call Now
        </a>
        <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="mobile-bar-btn mobile-bar-whatsapp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp
        </a>
        <a href="/free-audit" class="mobile-bar-btn mobile-bar-audit">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Free Audit
        </a>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%20Bharat%20SEO%2C%20I%20want%20to%20know%20more%20about%20your%20services." target="_blank" class="floating-whatsapp" aria-label="Chat on WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <main id="main-content">
