<?php
/**
 * Case Studies Page - Bharat SEO
 */
$pageSeo = getSeoSettings('case_studies');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Case Studies', 'url' => SITE_URL . '/case-studies']
    ])
];

$cases = getDB()->query("SELECT * FROM case_studies WHERE is_active = 1 ORDER BY created_at DESC")->fetchAll();
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Case Studies</span>
        </nav>
        <h1>Case Studies</h1>
        <p>Real examples of how Bharat SEO has helped local businesses improve their online presence and get more enquiries.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container">
        <?php if ($cases): ?>
        <div class="case-grid">
            <?php foreach ($cases as $case): ?>
            <a href="/case-studies/<?= sanitize($case['slug']) ?>" class="case-card">
                <div class="case-card-image">
                    <?php if ($case['featured_image']): ?>
                    <img src="<?= sanitize($case['featured_image']) ?>" alt="<?= sanitize($case['title']) ?>" loading="lazy">
                    <?php else: ?>
                    Case Study
                    <?php endif; ?>
                </div>
                <div class="case-card-body">
                    <span class="case-card-tag"><?= sanitize($case['industry']) ?> • <?= sanitize($case['city']) ?></span>
                    <h3><?= sanitize($case['title']) ?></h3>
                    <p><?= sanitize(truncateText($case['result_summary'] ?? '', 120)) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 4rem 1rem; color: var(--color-muted);">
            <p>Case studies are being documented. Contact us to learn about our client results.</p>
            <a href="/free-audit" class="btn btn-primary" style="margin-top: 1.5rem;">Get Free Audit</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Want Your Business To Be Our Next Success Story?</h2>
        <p>Start with a free business audit and let us show you the growth opportunities.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Business Audit</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
