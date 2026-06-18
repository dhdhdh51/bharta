<?php
/**
 * Admin - Services Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        // Allow either an uploaded file OR a pasted URL for icon & featured image
        $iconUpload  = handleImageUpload('icon_file');
        $imageUpload = handleImageUpload('featured_image_file');
        $data = [
            'title' => sanitize($_POST['title'] ?? ''),
            'slug' => createSlug($_POST['slug'] ?: $_POST['title']),
            'icon' => $iconUpload ?: sanitize($_POST['icon'] ?? ''),
            'featured_image' => $imageUpload ?: sanitize($_POST['featured_image'] ?? ''),
            'short_description' => sanitize($_POST['short_description'] ?? ''),
            'full_description' => sanitize($_POST['full_description'] ?? ''),
            'benefits' => $_POST['benefits'] ?? '[]',
            'deliverables' => $_POST['deliverables'] ?? '[]',
            'ideal_for' => $_POST['ideal_for'] ?? '[]',
            'faqs' => $_POST['faqs'] ?? '[]',
            'cta_text' => sanitize($_POST['cta_text'] ?? 'Get Started'),
            'sort_order' => intval($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'meta_title' => sanitize($_POST['meta_title'] ?? ''),
            'meta_description' => sanitize($_POST['meta_description'] ?? ''),
            'meta_keywords' => sanitize($_POST['meta_keywords'] ?? ''),
            'schema_json' => $_POST['schema_json'] ?? '',
        ];

        $id = intval($_POST['id'] ?? 0);
        if ($id) {
            $stmt = getDB()->prepare("UPDATE services SET title=?, slug=?, icon=?, featured_image=?, short_description=?, full_description=?, benefits=?, deliverables=?, ideal_for=?, faqs=?, cta_text=?, sort_order=?, is_active=?, meta_title=?, meta_description=?, meta_keywords=?, schema_json=? WHERE id=?");
            $stmt->execute([...array_values($data), $id]);
        } else {
            $stmt = getDB()->prepare("INSERT INTO services (title, slug, icon, featured_image, short_description, full_description, benefits, deliverables, ideal_for, faqs, cta_text, sort_order, is_active, meta_title, meta_description, meta_keywords, schema_json) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array_values($data));
        }
        setFlash('success', 'Service saved.');
        redirect('/admin/?page=services');
    }

    if ($postAction === 'delete') {
        getDB()->prepare("DELETE FROM services WHERE id = ?")->execute([intval($_POST['id'])]);
        setFlash('success', 'Service deleted.');
        redirect('/admin/?page=services');
    }
}

require __DIR__ . '/admin-header.php';
?>

<?php if ($action === 'list'): ?>
<div class="admin-page-header">
    <h1 class="admin-page-title">Services</h1>
    <a href="/admin/?page=services&action=add" class="admin-btn admin-btn-primary">Add Service</a>
</div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>

<?php $services = getDB()->query("SELECT * FROM services ORDER BY sort_order ASC")->fetchAll(); ?>
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Slug</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td><strong><?= sanitize($s['title']) ?></strong></td>
                <td><small>/services/<?= sanitize($s['slug']) ?></small></td>
                <td><?= $s['sort_order'] ?></td>
                <td><?= $s['is_active'] ? '✓' : '✕' ?></td>
                <td>
                    <a href="/admin/?page=services&action=edit&id=<?= $s['id'] ?>" class="admin-btn admin-btn-sm">Edit</a>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<?php
$service = ['title'=>'','slug'=>'','icon'=>'','featured_image'=>'','short_description'=>'','full_description'=>'','benefits'=>'[]','deliverables'=>'[]','ideal_for'=>'[]','faqs'=>'[]','cta_text'=>'Get Started','sort_order'=>0,'is_active'=>1,'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','schema_json'=>''];
if ($editId) {
    $stmt = getDB()->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$editId]);
    $service = $stmt->fetch() ?: $service;
}
?>
<h1 class="admin-page-title"><?= $editId ? 'Edit' : 'Add' ?> Service</h1>
<form method="POST" class="admin-form" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= $editId ?>">

    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Title *</label><input type="text" name="title" value="<?= sanitize($service['title']) ?>" required class="admin-input"></div>
        <div class="admin-form-group"><label>Slug</label><input type="text" name="slug" value="<?= sanitize($service['slug']) ?>" class="admin-input" placeholder="Auto-generated from title"></div>
    </div>
    <div class="admin-form-grid">
        <div class="admin-form-group">
            <label>Icon — Upload image</label>
            <input type="file" name="icon_file" accept="image/*" class="admin-input">
            <label style="margin-top:.5rem">…or paste Icon URL</label>
            <input type="text" name="icon" value="<?= sanitize($service['icon']) ?>" class="admin-input" placeholder="https://...">
            <?php if (!empty($service['icon'])): ?><img src="<?= sanitize($service['icon']) ?>" alt="" style="margin-top:.5rem;max-height:48px;border-radius:6px"><?php endif; ?>
        </div>
        <div class="admin-form-group">
            <label>Featured Image — Upload image</label>
            <input type="file" name="featured_image_file" accept="image/*" class="admin-input">
            <label style="margin-top:.5rem">…or paste Featured Image URL</label>
            <input type="text" name="featured_image" value="<?= sanitize($service['featured_image']) ?>" class="admin-input" placeholder="https://...">
            <?php if (!empty($service['featured_image'])): ?><img src="<?= sanitize($service['featured_image']) ?>" alt="" style="margin-top:.5rem;max-height:64px;border-radius:6px"><?php endif; ?>
        </div>
    </div>
    <div class="admin-form-group"><label>Short Description</label><textarea name="short_description" class="admin-input" rows="3"><?= sanitize($service['short_description']) ?></textarea></div>
    <div class="admin-form-group"><label>Full Description</label><textarea name="full_description" class="admin-input" rows="6"><?= sanitize($service['full_description']) ?></textarea></div>
    <div class="admin-form-group"><label>Benefits (JSON array)</label><textarea name="benefits" class="admin-input" rows="3"><?= sanitize($service['benefits']) ?></textarea></div>
    <div class="admin-form-group"><label>Deliverables (JSON array)</label><textarea name="deliverables" class="admin-input" rows="3"><?= sanitize($service['deliverables']) ?></textarea></div>
    <div class="admin-form-group"><label>Ideal For (JSON array)</label><textarea name="ideal_for" class="admin-input" rows="2"><?= sanitize($service['ideal_for']) ?></textarea></div>
    <div class="admin-form-group"><label>FAQs (JSON array of {q,a})</label><textarea name="faqs" class="admin-input" rows="4"><?= sanitize($service['faqs']) ?></textarea></div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>CTA Text</label><input type="text" name="cta_text" value="<?= sanitize($service['cta_text']) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $service['sort_order'] ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $service['is_active'] ? 'checked' : '' ?>> Active</label></div>

    <h3 style="margin-top: 2rem; margin-bottom: 1rem;">SEO Settings</h3>
    <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($service['meta_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-input" rows="2"><?= sanitize($service['meta_description']) ?></textarea></div>
    <div class="admin-form-group"><label>Meta Keywords</label><input type="text" name="meta_keywords" value="<?= sanitize($service['meta_keywords']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Schema JSON</label><textarea name="schema_json" class="admin-input" rows="3"><?= sanitize($service['schema_json']) ?></textarea></div>

    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn-primary">Save Service</button>
        <a href="/admin/?page=services" class="admin-btn">Cancel</a>
    </div>
</form>
<?php endif; ?>

<?php require __DIR__ . '/admin-footer.php'; ?>
