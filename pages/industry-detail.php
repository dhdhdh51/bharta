<?php
/**
 * Industry Detail Page - Bharat SEO
 */
$slug = $_GET['slug'] ?? '';
$stmt = getDB()->prepare("SELECT * FROM industries WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$industry = $stmt->fetch();

if (!$industry) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$seoOverrides = [
    'meta_title' => $industry['meta_title'] ?: $industry['title'] . ' - Bharat SEO',
    'meta_description' => $industry['meta_description'] ?: $industry['hero_text'],
    'meta_keywords' => $industry['meta_keywords'] ?? '',
];

$pageSeo = getSeoSettings('industries');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Industries', 'url' => SITE_URL . '/industries'],
        ['name' => $industry['title'], 'url' => SITE_URL . '/industries/' . $industry['slug']]
    ])
];

$painPoints = jsonDecode($industry['pain_points'] ?? '[]');
$benefits = jsonDecode($industry['benefits'] ?? '[]');
$faqs = jsonDecode($industry['faqs'] ?? '[]');

if ($faqs) {
    $pageSchemas[] = getFaqSchema($faqs);
}

// LocalBusiness schema for niche
$nicheSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $industry['title'],
    'description' => $industry['hero_text'],
    'provider' => [
        '@type' => 'ProfessionalService',
        'name' => getSetting('agency_name', 'Bharat SEO'),
    ],
];
$pageSchemas[] = $nicheSchema;

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header" style="padding-bottom: 3rem;">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><a href="/industries">Industries</a><span class="breadcrumb-sep">/</span><span><?= sanitize($industry['title']) ?></span>
        </nav>
        <h1><?= sanitize($industry['hero_heading'] ?: $industry['title']) ?></h1>
        <p><?= sanitize($industry['hero_text']) ?></p>
        <div style="margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem;">
            <a href="/free-audit" class="btn btn-primary">Get Free Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-secondary">WhatsApp Us</a>
        </div>
    </div>
</section>

<!-- Pain Points -->
<?php if ($painPoints): ?>
<section class="section fade-up">
    <div class="container">
        <h2 class="section-heading">Common Challenges You Face</h2>
        <div class="problem-list" style="max-width: 700px;">
            <?php foreach ($painPoints as $point): ?>
            <div class="problem-item">
                <div class="problem-item-icon">✕</div>
                <p><?= sanitize($point) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Benefits / What We Provide -->
<?php if ($benefits): ?>
<section class="section section-gray fade-up">
    <div class="container">
        <h2 class="section-heading">How Bharat SEO Helps</h2>
        <div class="solution-list" style="max-width: 700px;">
            <?php foreach ($benefits as $benefit): ?>
            <div class="solution-item">
                <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                <p><?= sanitize($benefit) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Process -->
<section class="section fade-up">
    <div class="container section-center">
        <h2 class="section-heading">Our Process</h2>
        <div class="steps-grid" style="max-width: 900px; margin: 2.5rem auto 0;">
            <div class="step-item">
                <div class="step-number">1</div>
                <h3>Free Audit</h3>
                <p>We analyse your current online presence and identify opportunities.</p>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <h3>Custom Plan</h3>
                <p>We create a growth plan specific to your business type and location.</p>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <h3>Implementation</h3>
                <p>We build your website, optimise profiles and set up lead systems.</p>
            </div>
            <div class="step-item">
                <div class="step-number">4</div>
                <h3>Launch</h3>
                <p>Everything goes live and customers can find and contact you.</p>
            </div>
            <div class="step-item">
                <div class="step-number">5</div>
                <h3>Growth</h3>
                <p>Monthly support to improve rankings, content and lead flow.</p>
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

<!-- Lead Form + CTA -->
<section class="cta-section fade-up">
    <div class="container">
        <h2>Ready to Grow Your <?= sanitize(str_replace('Digital Marketing for ', '', $industry['title'])) ?>?</h2>
        <p>Get a free audit and discover exactly what you need to get more customers online.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg"><?= sanitize($industry['cta_text'] ?: 'Get Free Audit') ?></a>
            <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%2C%20I%20run%20a%20<?= urlencode(str_replace('Digital Marketing for ', '', $industry['title'])) ?>%20and%20need%20help%20with%20digital%20marketing." target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
