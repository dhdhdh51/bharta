<?php
/**
 * Admin - SEO Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pageKey = $_POST['page_key'] ?? '';
    if ($pageKey) {
        $stmt = getDB()->prepare("UPDATE seo_settings SET meta_title=?, meta_description=?, meta_keywords=?, canonical_url=?, robots_meta=?, og_title=?, og_description=?, og_image=?, twitter_title=?, twitter_description=?, twitter_image=?, focus_keyword=?, schema_json=?, custom_header_scripts=?, custom_footer_scripts=? WHERE page_key=?");
        $stmt->execute([
            $_POST['meta_title']??'', $_POST['meta_description']??'', $_POST['meta_keywords']??'',
            $_POST['canonical_url']??'', $_POST['robots_meta']??'index, follow',
            $_POST['og_title']??'', $_POST['og_description']??'', $_POST['og_image']??'',
            $_POST['twitter_title']??'', $_POST['twitter_description']??'', $_POST['twitter_image']??'',
            $_POST['focus_keyword']??'', $_POST['schema_json']??'',
            $_POST['custom_header_scripts']??'', $_POST['custom_footer_scripts']??'', $pageKey
        ]);
        setFlash('success', 'SEO settings updated for ' . $pageKey);
        redirect('/admin/?page=seo');
    }
}

$seoPages = getDB()->query("SELECT * FROM seo_settings ORDER BY id ASC")->fetchAll();
$editPage = $_GET['edit'] ?? '';
$editData = null;
if ($editPage) {
    $stmt = getDB()->prepare("SELECT * FROM seo_settings WHERE page_key = ?");
    $stmt->execute([$editPage]);
    $editData = $stmt->fetch();
}

require __DIR__ . '/admin-header.php';
?>

<h1 class="admin-page-title">SEO Manager</h1>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>

<?php if ($editData): ?>
<h2 style="margin-bottom: 1.5rem;">Editing: <?= sanitize($editData['page_name']) ?></h2>
<form method="POST" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    <input type="hidden" name="page_key" value="<?= sanitize($editData['page_key']) ?>">
    <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($editData['meta_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-input" rows="3"><?= sanitize($editData['meta_description']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Meta Keywords</label><input type="text" name="meta_keywords" value="<?= sanitize($editData['meta_keywords']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Focus Keyword</label><input type="text" name="focus_keyword" value="<?= sanitize($editData['focus_keyword']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Canonical URL</label><input type="text" name="canonical_url" value="<?= sanitize($editData['canonical_url']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Robots Meta</label><input type="text" name="robots_meta" value="<?= sanitize($editData['robots_meta']) ?>" class="admin-input"></div></div>
    <h3 style="margin: 1.5rem 0 1rem;">Open Graph</h3>
    <div class="admin-form-group"><label>OG Title</label><input type="text" name="og_title" value="<?= sanitize($editData['og_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>OG Description</label><textarea name="og_description" class="admin-input" rows="2"><?= sanitize($editData['og_description']) ?></textarea></div>
    <div class="admin-form-group"><label>OG Image</label><input type="text" name="og_image" value="<?= sanitize($editData['og_image']) ?>" class="admin-input"></div>
    <h3 style="margin: 1.5rem 0 1rem;">Twitter Card</h3>
    <div class="admin-form-group"><label>Twitter Title</label><input type="text" name="twitter_title" value="<?= sanitize($editData['twitter_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Twitter Description</label><textarea name="twitter_description" class="admin-input" rows="2"><?= sanitize($editData['twitter_description']) ?></textarea></div>
    <div class="admin-form-group"><label>Twitter Image</label><input type="text" name="twitter_image" value="<?= sanitize($editData['twitter_image']) ?>" class="admin-input"></div>
    <h3 style="margin: 1.5rem 0 1rem;">Schema & Scripts</h3>
    <div class="admin-form-group"><label>Schema JSON</label><textarea name="schema_json" class="admin-input" rows="4"><?= sanitize($editData['schema_json']) ?></textarea></div>
    <div class="admin-form-group"><label>Custom Header Scripts</label><textarea name="custom_header_scripts" class="admin-input" rows="3"><?= htmlspecialchars($editData['custom_header_scripts']??'') ?></textarea></div>
    <div class="admin-form-group"><label>Custom Footer Scripts</label><textarea name="custom_footer_scripts" class="admin-input" rows="3"><?= htmlspecialchars($editData['custom_footer_scripts']??'') ?></textarea></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save SEO Settings</button><a href="/admin/?page=seo" class="admin-btn">Back</a></div>
</form>
<?php else: ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Page</th><th>Meta Title</th><th>Robots</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($seoPages as $sp): ?>
<tr><td><strong><?= sanitize($sp['page_name']) ?></strong><br><small><?= sanitize($sp['page_key']) ?></small></td><td><small><?= sanitize(truncateText($sp['meta_title']??'', 50)) ?></small></td><td><small><?= sanitize($sp['robots_meta']) ?></small></td><td><a href="/admin/?page=seo&edit=<?= $sp['page_key'] ?>" class="admin-btn admin-btn-sm admin-btn-primary">Edit</a></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>

<?php require __DIR__ . '/admin-footer.php'; ?>
