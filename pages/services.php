<?php
/**
 * Services Page - Bharat SEO
 */
$pageSeo = getSeoSettings('services');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Services', 'url' => SITE_URL . '/services']
    ])
];

$services = getDB()->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Services</span>
        </nav>
        <h1>Our Services</h1>
        <p>Everything your local business needs to grow online — from professional websites to Google Map visibility and WhatsApp lead systems.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container">
        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
            <?php foreach ($services as $service): ?>
            <div class="service-card">
                <div class="service-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <h3><?= sanitize($service['title']) ?></h3>
                <p><?= sanitize($service['short_description']) ?></p>
                <a href="/services/<?= sanitize($service['slug']) ?>" class="service-card-link">View Details →</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Not Sure Which Service You Need?</h2>
        <p>Request a free business audit and we will recommend the right services based on your goals and current online presence.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">Ask on WhatsApp</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
