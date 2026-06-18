<?php
/**
 * Blog Page - Bharat SEO
 */
$pageSeo = getSeoSettings('blog');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Blog', 'url' => SITE_URL . '/blog']
    ])
];

// Pagination
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

// Category filter
$categorySlug = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

$where = "WHERE bp.status = 'published' AND bp.publish_date <= NOW()";
$params = [];

if ($categorySlug) {
    $where .= " AND bc.slug = ?";
    $params[] = $categorySlug;
}
if ($search) {
    $where .= " AND (bp.title LIKE ? OR bp.content LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$countStmt = getDB()->prepare("SELECT COUNT(*) FROM blog_posts bp LEFT JOIN blog_categories bc ON bp.category_id = bc.id $where");
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $perPage);

$stmt = getDB()->prepare("SELECT bp.*, bc.name as category_name, bc.slug as category_slug FROM blog_posts bp LEFT JOIN blog_categories bc ON bp.category_id = bc.id $where ORDER BY bp.publish_date DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$posts = $stmt->fetchAll();

// Categories for filter
$categories = getDB()->query("SELECT * FROM blog_categories WHERE is_active = 1 ORDER BY name ASC")->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Blog</span>
        </nav>
        <h1>Blog</h1>
        <p>Tips, guides and strategies for local business growth, SEO, website design and digital marketing.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Search & Filter -->
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; align-items: center;">
            <form method="GET" action="/blog" style="display: flex; gap: 0.5rem; flex: 1; min-width: 250px;">
                <input type="text" name="search" placeholder="Search articles..." value="<?= sanitize($search) ?>" style="flex: 1; padding: 0.7rem 1rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem;">
                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            </form>
            <div class="filter-bar" style="margin: 0;">
                <a href="/blog" class="filter-btn <?= !$categorySlug ? 'active' : '' ?>">All</a>
                <?php foreach ($categories as $cat): ?>
                <a href="/blog?category=<?= sanitize($cat['slug']) ?>" class="filter-btn <?= $categorySlug === $cat['slug'] ? 'active' : '' ?>"><?= sanitize($cat['name']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($posts): ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <a href="/blog/<?= sanitize($post['slug']) ?>" class="blog-card">
                <div class="blog-card-image">
                    <?php if ($post['featured_image']): ?>
                    <img src="<?= sanitize($post['featured_image']) ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="blog-card-body">
                    <div class="blog-card-meta">
                        <?php if ($post['category_name']): ?>
                        <span><?= sanitize($post['category_name']) ?></span> •
                        <?php endif; ?>
                        <span><?= date('M j, Y', strtotime($post['publish_date'])) ?></span>
                    </div>
                    <h3><?= sanitize($post['title']) ?></h3>
                    <p><?= sanitize(truncateText($post['excerpt'] ?? '', 120)) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/blog?page=<?= $i ?><?= $categorySlug ? '&category=' . $categorySlug : '' ?>" class="btn btn-sm <?= $i === $page ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div style="text-align: center; padding: 4rem 1rem; color: var(--color-muted);">
            <p>No blog posts found. <?= $search ? 'Try a different search term.' : 'New articles will be published soon.' ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
