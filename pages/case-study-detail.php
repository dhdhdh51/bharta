<?php
/**
 * Case Study Detail Page - Bharat SEO
 */
$slug = $_GET['slug'] ?? '';
$stmt = getDB()->prepare("SELECT * FROM case_studies WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$case = $stmt->fetch();

if (!$case) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$seoOverrides = [
    'meta_title' => $case['meta_title'] ?: $case['title'] . ' - Bharat SEO Case Study',
    'meta_description' => $case['meta_description'] ?: truncateText($case['result_summary'], 160),
];

$pageSeo = getSeoSettings('case_studies');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Case Studies', 'url' => SITE_URL . '/case-studies'],
        ['name' => $case['title'], 'url' => SITE_URL . '/case-studies/' . $case['slug']]
    ])
];

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><a href="/case-studies">Case Studies</a><span class="breadcrumb-sep">/</span><span><?= sanitize($case['title']) ?></span>
        </nav>
        <span class="case-card-tag" style="margin-bottom: 1rem; display: inline-block;"><?= sanitize($case['industry']) ?> • <?= sanitize($case['city']) ?></span>
        <h1><?= sanitize($case['title']) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="problem-grid">
            <div>
                <?php if ($case['challenge']): ?>
                <h2 style="margin-bottom: 1rem;">The Challenge</h2>
                <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 2rem;"><?= nl2br(sanitize($case['challenge'])) ?></p>
                <?php endif; ?>

                <?php if ($case['strategy']): ?>
                <h2 style="margin-bottom: 1rem;">Our Strategy</h2>
                <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 2rem;"><?= nl2br(sanitize($case['strategy'])) ?></p>
                <?php endif; ?>

                <?php if ($case['work_done']): ?>
                <h2 style="margin-bottom: 1rem;">Work Done</h2>
                <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 2rem;"><?= nl2br(sanitize($case['work_done'])) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <div style="background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 2rem; position: sticky; top: calc(var(--header-height) + 2rem);">
                    <h3 style="margin-bottom: 1.25rem;">Results</h3>
                    <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 1.5rem;"><?= nl2br(sanitize($case['result_summary'])) ?></p>

                    <?php if ($case['website_url']): ?>
                    <p style="margin-bottom: 0.5rem;"><a href="<?= sanitize($case['website_url']) ?>" target="_blank" rel="noopener" style="color: var(--color-accent); font-weight: 600;">Visit Website →</a></p>
                    <?php endif; ?>

                    <?php if ($case['google_maps_link']): ?>
                    <p><a href="<?= sanitize($case['google_maps_link']) ?>" target="_blank" rel="noopener" style="color: var(--color-accent); font-weight: 600;">View on Google Maps →</a></p>
                    <?php endif; ?>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border);">
                        <a href="/free-audit" class="btn btn-primary" style="width: 100%;">Get Similar Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Want Results Like This For Your Business?</h2>
        <p>Start with a free audit and see what is possible for your business.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Business Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
