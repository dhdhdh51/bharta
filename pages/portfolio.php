<?php
/**
 * Portfolio Page - Bharat SEO
 */
$pageSeo = getSeoSettings('portfolio');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Portfolio', 'url' => SITE_URL . '/portfolio']
    ])
];

$projects = getDB()->query("SELECT * FROM portfolio WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

// Get unique industries for filters
$filters = array_unique(array_filter(array_column($projects, 'industry')));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Portfolio</span>
        </nav>
        <h1>Our Work</h1>
        <p>See the websites, optimisations and digital systems we have built for local businesses across India.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container">
        <?php if ($filters): ?>
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">All</button>
            <?php foreach ($filters as $filter): ?>
            <button class="filter-btn" data-filter="<?= sanitize(strtolower($filter)) ?>"><?= sanitize($filter) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($projects): ?>
        <div class="case-grid">
            <?php foreach ($projects as $project): ?>
            <div class="case-card" data-category="<?= sanitize(strtolower($project['industry'] ?? '')) ?>">
                <div class="case-card-image">
                    <?php if ($project['screenshot']): ?>
                    <img src="<?= sanitize($project['screenshot']) ?>" alt="<?= sanitize($project['title']) ?>" loading="lazy">
                    <?php else: ?>
                    Project Preview
                    <?php endif; ?>
                </div>
                <div class="case-card-body">
                    <?php if ($project['industry']): ?>
                    <span class="case-card-tag"><?= sanitize($project['industry']) ?></span>
                    <?php endif; ?>
                    <h3><?= sanitize($project['title']) ?></h3>
                    <?php if ($project['client_name']): ?>
                    <p style="margin-bottom: 0.5rem; font-size: 0.82rem; color: var(--color-muted);"><?= sanitize($project['client_name']) ?></p>
                    <?php endif; ?>
                    <p><?= sanitize(truncateText($project['summary'] ?? '', 100)) ?></p>
                    <?php if ($project['project_url']): ?>
                    <a href="<?= sanitize($project['project_url']) ?>" target="_blank" rel="noopener" class="service-card-link" style="margin-top: 0.75rem; display: inline-flex;">Visit Website →</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 4rem 1rem; color: var(--color-muted);">
            <p>Portfolio projects will be added soon. Check back later or contact us to see sample work.</p>
            <a href="/free-audit" class="btn btn-primary" style="margin-top: 1.5rem;">Get Free Audit</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section fade-up">
    <div class="container">
        <h2>Want Similar Results For Your Business?</h2>
        <p>Let us build a professional online presence that brings you more customers.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
