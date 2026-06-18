<?php
/**
 * Industries Page - Bharat SEO
 */
$pageSeo = getSeoSettings('industries');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Industries', 'url' => SITE_URL . '/industries']
    ])
];

$industries = getDB()->query("SELECT * FROM industries WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Industries</span>
        </nav>
        <h1>Industries We Serve</h1>
        <p>Specialised digital marketing solutions designed for local businesses that need more customers from their area.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container">
        <div class="industry-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
            <?php foreach ($industries as $industry): ?>
            <a href="/industries/<?= sanitize($industry['slug']) ?>" class="industry-card" style="padding: 2rem; text-align: left;">
                <div class="industry-card-icon" style="margin: 0 0 1rem 0;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-secondary)" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 style="font-size: 1rem; margin-bottom: 0.5rem;"><?= sanitize($industry['title']) ?></h3>
                <p style="font-size: 0.85rem; color: var(--color-muted); line-height: 1.6;"><?= sanitize(truncateText($industry['hero_text'] ?? '', 80)) ?></p>
                <span class="service-card-link" style="margin-top: 0.75rem; display: inline-flex;">Learn More →</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Do Not See Your Industry?</h2>
        <p>We work with all types of local businesses. Contact us for a custom growth plan for your specific business type.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
