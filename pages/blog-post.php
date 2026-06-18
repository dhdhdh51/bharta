<?php
/**
 * Blog Post Page - Bharat SEO
 */
$slug = $_GET['slug'] ?? '';
$stmt = getDB()->prepare("SELECT bp.*, bc.name as category_name, bc.slug as category_slug FROM blog_posts bp LEFT JOIN blog_categories bc ON bp.category_id = bc.id WHERE bp.slug = ? AND bp.status = 'published'");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

// Increment views
$updateStmt = getDB()->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
$updateStmt->execute([$post['id']]);

$seoOverrides = [
    'meta_title' => $post['meta_title'] ?: $post['title'] . ' - Bharat SEO Blog',
    'meta_description' => $post['meta_description'] ?: truncateText($post['excerpt'] ?? '', 160),
    'meta_keywords' => $post['meta_keywords'] ?? '',
    'canonical_url' => $post['canonical_url'] ?: SITE_URL . '/blog/' . $post['slug'],
];

$pageSeo = $post;
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Blog', 'url' => SITE_URL . '/blog'],
        ['name' => $post['title'], 'url' => SITE_URL . '/blog/' . $post['slug']]
    ]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post['title'],
        'description' => $post['excerpt'] ?? '',
        'author' => ['@type' => 'Person', 'name' => $post['author']],
        'datePublished' => $post['publish_date'],
        'dateModified' => $post['updated_at'],
        'publisher' => [
            '@type' => 'Organization',
            'name' => getSetting('agency_name', 'Bharat SEO'),
            'url' => getSetting('canonical_site_url', SITE_URL),
        ],
        'mainEntityOfPage' => SITE_URL . '/blog/' . $post['slug'],
        'image' => $post['featured_image'] ? SITE_URL . $post['featured_image'] : '',
    ]
];

// FAQ schema if present
$postFaqs = jsonDecode($post['faqs'] ?? '[]');
if ($postFaqs) {
    $pageSchemas[] = getFaqSchema($postFaqs);
}

// Related posts
$relatedStmt = getDB()->prepare("SELECT * FROM blog_posts WHERE id != ? AND status = 'published' AND category_id = ? ORDER BY publish_date DESC LIMIT 3");
$relatedStmt->execute([$post['id'], $post['category_id']]);
$relatedPosts = $relatedStmt->fetchAll();

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<article>
    <header class="blog-post-header">
        <div class="container" style="max-width: 750px;">
            <nav class="breadcrumb-list" aria-label="Breadcrumb" style="margin-bottom: 1.5rem;">
                <a href="/">Home</a><span class="breadcrumb-sep">/</span><a href="/blog">Blog</a><span class="breadcrumb-sep">/</span><span><?= sanitize(truncateText($post['title'], 40)) ?></span>
            </nav>
            <?php if ($post['category_name']): ?>
            <a href="/blog?category=<?= sanitize($post['category_slug']) ?>" class="case-card-tag" style="margin-bottom: 1rem; display: inline-block;"><?= sanitize($post['category_name']) ?></a>
            <?php endif; ?>
            <h1 style="font-size: clamp(1.75rem, 4vw, 2.5rem);"><?= sanitize($post['title']) ?></h1>
            <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.25rem; font-size: 0.88rem; color: var(--color-muted);">
                <span>By <?= sanitize($post['author']) ?></span>
                <span>•</span>
                <time datetime="<?= $post['publish_date'] ?>"><?= date('F j, Y', strtotime($post['publish_date'])) ?></time>
            </div>
        </div>
    </header>

    <?php if ($post['featured_image']): ?>
    <div class="container" style="max-width: 750px; margin-top: 2rem;">
        <img src="<?= sanitize($post['featured_image']) ?>" alt="<?= sanitize($post['title']) ?>" style="width: 100%; border-radius: var(--radius-md);">
    </div>
    <?php endif; ?>

    <div class="blog-post-content">
        <?= $post['content'] ?>
    </div>

    <!-- Post FAQs -->
    <?php if ($postFaqs): ?>
    <section class="section section-gray">
        <div class="container" style="max-width: 750px;">
            <h2 style="margin-bottom: 1.5rem;">Frequently Asked Questions</h2>
            <div class="faq-list" style="margin-top: 0;">
                <?php foreach ($postFaqs as $faq): ?>
                <div class="faq-item">
                    <button class="faq-question"><?= sanitize($faq['q']) ?></button>
                    <div class="faq-answer"><p><?= sanitize($faq['a']) ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Share -->
    <div class="container" style="max-width: 750px; padding: 2rem 1.25rem; border-top: 1px solid var(--color-border);">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span style="font-weight: var(--fw-semibold); font-size: 0.9rem;">Share this article:</span>
            <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . SITE_URL . '/blog/' . $post['slug']) ?>" target="_blank" class="btn btn-sm btn-secondary">WhatsApp</a>
            <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(SITE_URL . '/blog/' . $post['slug']) ?>" target="_blank" class="btn btn-sm btn-secondary">Twitter</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(SITE_URL . '/blog/' . $post['slug']) ?>" target="_blank" class="btn btn-sm btn-secondary">LinkedIn</a>
        </div>
    </div>
</article>

<!-- Related Posts -->
<?php if ($relatedPosts): ?>
<section class="section section-gray">
    <div class="container">
        <h2 style="margin-bottom: 2rem;">Related Articles</h2>
        <div class="blog-grid">
            <?php foreach ($relatedPosts as $related): ?>
            <a href="/blog/<?= sanitize($related['slug']) ?>" class="blog-card">
                <div class="blog-card-image">
                    <?php if ($related['featured_image']): ?>
                    <img src="<?= sanitize($related['featured_image']) ?>" alt="<?= sanitize($related['title']) ?>" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="blog-card-body">
                    <h3><?= sanitize($related['title']) ?></h3>
                    <p><?= sanitize(truncateText($related['excerpt'] ?? '', 100)) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Need Help Growing Your Business Online?</h2>
        <p>Get a free business audit and discover practical steps to improve your online presence.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
