<?php
/**
 * Packages Page - Bharat SEO
 */
$pageSeo = getSeoSettings('packages');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Packages', 'url' => SITE_URL . '/packages']
    ])
];

$packages = getDB()->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Packages</span>
        </nav>
        <h1>Simple Plans For Local Business Growth</h1>
        <p>Transparent pricing with no hidden fees. Choose the package that fits your business stage and goals.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container">
        <div class="packages-grid">
            <?php foreach ($packages as $pkg): ?>
            <div class="package-card <?= $pkg['is_highlighted'] ? 'highlighted' : '' ?>">
                <?php if ($pkg['is_highlighted']): ?>
                <span class="package-badge">Most Popular</span>
                <?php endif; ?>
                <h2 class="package-name"><?= sanitize($pkg['package_name']) ?></h2>
                <div class="package-price"><?= formatPrice($pkg['price']) ?></div>
                <?php if ($pkg['monthly_price']): ?>
                <div class="package-monthly">+ <?= formatPrice($pkg['monthly_price']) ?>/month support</div>
                <?php else: ?>
                <div class="package-monthly">One-time payment</div>
                <?php endif; ?>
                <?php if ($pkg['delivery_time']): ?>
                <p style="font-size: 0.82rem; color: var(--color-muted); margin-bottom: 1.5rem;">Delivery: <?= sanitize($pkg['delivery_time']) ?></p>
                <?php endif; ?>
                <ul class="package-features">
                    <?php foreach (jsonDecode($pkg['features']) as $feature): ?>
                    <li><?= sanitize($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%2C%20I%20am%20interested%20in%20the%20<?= urlencode($pkg['package_name']) ?>%20package." target="_blank" class="btn <?= $pkg['is_highlighted'] ? 'btn-primary' : 'btn-secondary' ?>"><?= sanitize($pkg['cta_text']) ?></a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Notes -->
        <div style="max-width: 700px; margin: 3rem auto 0; text-align: center;">
            <h3 style="margin-bottom: 1rem;">Important Notes</h3>
            <ul style="color: var(--color-muted); font-size: 0.9rem; line-height: 1.8; text-align: left; max-width: 500px; margin: 0 auto;">
                <li style="margin-bottom: 0.5rem;">• Domain and hosting costs are separate and vary by provider.</li>
                <li style="margin-bottom: 0.5rem;">• All prices are exclusive of applicable taxes.</li>
                <li style="margin-bottom: 0.5rem;">• Custom requirements may have additional costs discussed upfront.</li>
                <li style="margin-bottom: 0.5rem;">• Monthly support is optional and can be cancelled anytime.</li>
                <li>• All packages include initial consultation and planning.</li>
            </ul>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <h2 class="section-heading">Package Questions</h2>
        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question">Can I upgrade my package later?</button>
                <div class="faq-answer"><p>Yes, you can upgrade from Starter to Growth or Pro at any time. We will adjust the pricing based on what has already been delivered.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">What payment methods do you accept?</button>
                <div class="faq-answer"><p>We accept UPI, bank transfer, and online payment methods. Payment details are shared after confirming your requirements.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Is there a refund policy?</button>
                <div class="faq-answer"><p>Since our services involve custom work, refunds are handled on a case-by-case basis. We discuss all requirements clearly before starting to ensure alignment.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do I need to pay everything upfront?</button>
                <div class="faq-answer"><p>For Starter packages, full payment is collected upfront. For Growth and Pro, we typically work with 50% advance and 50% on delivery.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Can I get a custom package?</button>
                <div class="faq-answer"><p>Yes, if your needs do not fit our standard packages, we can create a custom plan. Contact us on WhatsApp to discuss your requirements.</p></div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Not Sure Which Package Is Right?</h2>
        <p>Get a free business audit first. We will recommend the best package based on your business type, goals and current situation.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit First</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">Ask on WhatsApp</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
