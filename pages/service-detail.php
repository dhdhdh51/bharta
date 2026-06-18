<?php
/**
 * Service Detail Page - Bharat SEO
 */
$slug = $_GET['slug'] ?? '';
$stmt = getDB()->prepare("SELECT * FROM services WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$service = $stmt->fetch();

if (!$service) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$seoOverrides = [
    'meta_title' => $service['meta_title'] ?: $service['title'] . ' - Bharat SEO',
    'meta_description' => $service['meta_description'] ?: $service['short_description'],
    'meta_keywords' => $service['meta_keywords'] ?? '',
];

$pageSeo = getSeoSettings('services');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Services', 'url' => SITE_URL . '/services'],
        ['name' => $service['title'], 'url' => SITE_URL . '/services/' . $service['slug']]
    ])
];

// Service Schema
$serviceSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $service['title'],
    'description' => $service['short_description'],
    'provider' => [
        '@type' => 'ProfessionalService',
        'name' => getSetting('agency_name', 'Bharat SEO'),
        'url' => getSetting('canonical_site_url', SITE_URL),
    ],
];
$pageSchemas[] = $serviceSchema;

// Parse JSON fields
$benefits = jsonDecode($service['benefits'] ?? '[]');
$deliverables = jsonDecode($service['deliverables'] ?? '[]');
$idealFor = jsonDecode($service['ideal_for'] ?? '[]');
$faqs = jsonDecode($service['faqs'] ?? '[]');

if ($faqs) {
    $pageSchemas[] = getFaqSchema($faqs);
}

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><a href="/services">Services</a><span class="breadcrumb-sep">/</span><span><?= sanitize($service['title']) ?></span>
        </nav>
        <h1><?= sanitize($service['title']) ?></h1>
        <p><?= sanitize($service['short_description']) ?></p>
    </div>
</section>

<!-- Full Description -->
<section class="section fade-up">
    <div class="container">
        <div class="problem-grid">
            <div>
                <h2>What We Do</h2>
                <div style="margin-top: 1.25rem; color: var(--color-muted); line-height: 1.8;">
                    <?= nl2br(sanitize($service['full_description'])) ?>
                </div>

                <?php if ($idealFor): ?>
                <h3 style="margin-top: 2rem; margin-bottom: 1rem;">Ideal For</h3>
                <ul style="color: var(--color-muted); line-height: 1.8;">
                    <?php foreach ($idealFor as $item): ?>
                    <li style="margin-bottom: 0.5rem; padding-left: 1.25rem; position: relative;">
                        <span style="position: absolute; left: 0; color: var(--color-accent);">•</span>
                        <?= sanitize($item) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <div>
                <?php if ($benefits): ?>
                <div style="background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 2rem; margin-bottom: 1.5rem;">
                    <h3 style="margin-bottom: 1.25rem;">Key Benefits</h3>
                    <div class="solution-list">
                        <?php foreach ($benefits as $benefit): ?>
                        <div class="solution-item">
                            <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                            <p><?= sanitize($benefit) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($deliverables): ?>
                <div style="background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 2rem;">
                    <h3 style="margin-bottom: 1.25rem;">What You Get</h3>
                    <ul style="color: var(--color-muted);">
                        <?php foreach ($deliverables as $item): ?>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid var(--color-border); display: flex; gap: 0.5rem; align-items: flex-start;">
                            <span style="color: var(--color-accent); font-weight: bold;">✓</span>
                            <?= sanitize($item) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<?php if ($faqs): ?>
<section class="section section-gray fade-up">
    <div class="container section-center">
        <h2 class="section-heading">Frequently Asked Questions</h2>
        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <button class="faq-question"><?= sanitize($faq['q']) ?></button>
                <div class="faq-answer"><p><?= sanitize($faq['a']) ?></p></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="cta-section fade-up">
    <div class="container">
        <h2>Ready to <?= sanitize($service['cta_text'] ?? 'Get Started') ?>?</h2>
        <p>Get a free audit to understand how this service can help your specific business grow.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Business Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%2C%20I%20am%20interested%20in%20<?= urlencode($service['title']) ?>" target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
