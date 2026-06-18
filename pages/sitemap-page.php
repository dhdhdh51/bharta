<?php
/**
 * Sitemap Page - Bharat SEO
 */
$pageSeo = getSeoSettings('sitemap_page');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Sitemap', 'url' => SITE_URL . '/sitemap']
    ])
];

$services = getDB()->query("SELECT title, slug FROM services WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$industries = getDB()->query("SELECT title, slug FROM industries WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$posts = getDB()->query("SELECT title, slug FROM blog_posts WHERE status = 'published' ORDER BY publish_date DESC LIMIT 20")->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Sitemap</span>
        </nav>
        <h1>Sitemap</h1>
        <p>Browse all pages on the Bharat SEO website.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem;">
            <div>
                <h2 style="font-size: 1.15rem; margin-bottom: 1rem;">Main Pages</h2>
                <ul style="color: var(--color-muted); line-height: 2;">
                    <li><a href="/" style="color: var(--color-accent);">Home</a></li>
                    <li><a href="/about" style="color: var(--color-accent);">About Bharat SEO</a></li>
                    <li><a href="/services" style="color: var(--color-accent);">Services</a></li>
                    <li><a href="/industries" style="color: var(--color-accent);">Industries</a></li>
                    <li><a href="/packages" style="color: var(--color-accent);">Packages</a></li>
                    <li><a href="/portfolio" style="color: var(--color-accent);">Portfolio</a></li>
                    <li><a href="/case-studies" style="color: var(--color-accent);">Case Studies</a></li>
                    <li><a href="/blog" style="color: var(--color-accent);">Blog</a></li>
                    <li><a href="/free-audit" style="color: var(--color-accent);">Free Business Audit</a></li>
                    <li><a href="/contact" style="color: var(--color-accent);">Contact</a></li>
                </ul>
            </div>

            <div>
                <h2 style="font-size: 1.15rem; margin-bottom: 1rem;">Services</h2>
                <ul style="color: var(--color-muted); line-height: 2;">
                    <?php foreach ($services as $s): ?>
                    <li><a href="/services/<?= sanitize($s['slug']) ?>" style="color: var(--color-accent);"><?= sanitize($s['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div>
                <h2 style="font-size: 1.15rem; margin-bottom: 1rem;">Industries</h2>
                <ul style="color: var(--color-muted); line-height: 2;">
                    <?php foreach ($industries as $ind): ?>
                    <li><a href="/industries/<?= sanitize($ind['slug']) ?>" style="color: var(--color-accent);"><?= sanitize($ind['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if ($posts): ?>
            <div>
                <h2 style="font-size: 1.15rem; margin-bottom: 1rem;">Recent Blog Posts</h2>
                <ul style="color: var(--color-muted); line-height: 2;">
                    <?php foreach ($posts as $p): ?>
                    <li><a href="/blog/<?= sanitize($p['slug']) ?>" style="color: var(--color-accent);"><?= sanitize($p['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div>
                <h2 style="font-size: 1.15rem; margin-bottom: 1rem;">Legal</h2>
                <ul style="color: var(--color-muted); line-height: 2;">
                    <li><a href="/privacy-policy" style="color: var(--color-accent);">Privacy Policy</a></li>
                    <li><a href="/terms-conditions" style="color: var(--color-accent);">Terms & Conditions</a></li>
                    <li><a href="/disclaimer" style="color: var(--color-accent);">Disclaimer</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
