<?php
/**
 * 404 Page - Bharat SEO
 */
$pageSeo = [];
$seoOverrides = [
    'meta_title' => 'Page Not Found - Bharat SEO',
    'meta_description' => 'The page you are looking for does not exist or has been moved.',
    'robots_meta' => 'noindex, nofollow',
];
$pageSchemas = [];

require_once __DIR__ . '/../includes/header.php';
?>

<section style="padding: calc(var(--header-height) + 5rem) 0 5rem; text-align: center; min-height: 65vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 550px;">
        <div style="font-size: 5rem; font-weight: var(--fw-extrabold); color: var(--color-border); margin-bottom: 1rem; line-height: 1;">404</div>
        <h1 style="font-size: 1.75rem; margin-bottom: 1rem;">Page Not Found</h1>
        <p style="color: var(--color-muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem;">The page you are looking for does not exist, has been moved or the URL might be incorrect. Here are some helpful links to get you back on track.</p>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; margin-bottom: 2.5rem;">
            <a href="/" class="btn btn-primary">Go Home</a>
            <a href="/services" class="btn btn-secondary">Our Services</a>
            <a href="/contact" class="btn btn-secondary">Contact Us</a>
        </div>
        <div style="border-top: 1px solid var(--color-border); padding-top: 2rem;">
            <p style="font-size: 0.9rem; color: var(--color-muted); margin-bottom: 1rem;">Looking for something specific?</p>
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; font-size: 0.88rem;">
                <a href="/free-audit" style="color: var(--color-accent);">Free Audit</a>
                <span style="color: var(--color-border);">•</span>
                <a href="/packages" style="color: var(--color-accent);">Packages</a>
                <span style="color: var(--color-border);">•</span>
                <a href="/blog" style="color: var(--color-accent);">Blog</a>
                <span style="color: var(--color-border);">•</span>
                <a href="/industries" style="color: var(--color-accent);">Industries</a>
                <span style="color: var(--color-border);">•</span>
                <a href="/sitemap" style="color: var(--color-accent);">Sitemap</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
