<?php
/**
 * Admin - Industries Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $postAction = $_POST['action'] ?? '';
    if ($postAction === 'save') {
        $imageUpload = handleImageUpload('featured_image_file');
        $data = [sanitize($_POST['title']??''), createSlug($_POST['slug']?:$_POST['title']), ($imageUpload ?: sanitize($_POST['featured_image']??'')), sanitize($_POST['hero_heading']??''), sanitize($_POST['hero_text']??''), $_POST['pain_points']??'[]', $_POST['benefits']??'[]', $_POST['services_offered']??'', $_POST['process_steps']??'', $_POST['faqs']??'[]', sanitize($_POST['cta_text']??'Get Free Audit'), intval($_POST['sort_order']??0), isset($_POST['is_active'])?1:0, sanitize($_POST['meta_title']??''), sanitize($_POST['meta_description']??''), sanitize($_POST['meta_keywords']??''), $_POST['schema_json']??''];
        $id = intval($_POST['id']??0);
        if ($id) {
            $stmt = getDB()->prepare("UPDATE industries SET title=?,slug=?,featured_image=?,hero_heading=?,hero_text=?,pain_points=?,benefits=?,services_offered=?,process_steps=?,faqs=?,cta_text=?,sort_order=?,is_active=?,meta_title=?,meta_description=?,meta_keywords=?,schema_json=? WHERE id=?");
            $stmt->execute([...$data, $id]);
        } else {
            $stmt = getDB()->prepare("INSERT INTO industries (title,slug,featured_image,hero_heading,hero_text,pain_points,benefits,services_offered,process_steps,faqs,cta_text,sort_order,is_active,meta_title,meta_description,meta_keywords,schema_json) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute($data);
        }
        setFlash('success', 'Industry saved.');
        redirect('/admin/?page=industries');
    }
    if ($postAction === 'delete') {
        getDB()->prepare("DELETE FROM industries WHERE id=?")->execute([intval($_POST['id'])]);
        setFlash('success', 'Industry deleted.');
        redirect('/admin/?page=industries');
    }
}

require __DIR__ . '/admin-header.php';
?>

<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Industries</h1><a href="/admin/?page=industries&action=add" class="admin-btn admin-btn-primary">Add Industry</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $items = getDB()->query("SELECT * FROM industries ORDER BY sort_order ASC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Slug</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($items as $item): ?>
<tr><td><?= sanitize($item['title']) ?></td><td><small>/industries/<?= sanitize($item['slug']) ?></small></td><td><?= $item['is_active']?'✓':'✕' ?></td><td><a href="/admin/?page=industries&action=edit&id=<?= $item['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $item['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?>
</tbody></table></div>

<?php else: ?>
<?php
$item = ['title'=>'','slug'=>'','featured_image'=>'','hero_heading'=>'','hero_text'=>'','pain_points'=>'[]','benefits'=>'[]','services_offered'=>'','process_steps'=>'','faqs'=>'[]','cta_text'=>'Get Free Audit','sort_order'=>0,'is_active'=>1,'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','schema_json'=>''];
if ($editId) { $s = getDB()->prepare("SELECT * FROM industries WHERE id=?"); $s->execute([$editId]); $item = $s->fetch() ?: $item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'Add' ?> Industry</h1>
<form method="POST" class="admin-form" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-grid"><div class="admin-form-group"><label>Title *</label><input type="text" name="title" value="<?= sanitize($item['title']) ?>" required class="admin-input"></div><div class="admin-form-group"><label>Slug</label><input type="text" name="slug" value="<?= sanitize($item['slug']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group">
        <label>Featured Image — Upload image</label>
        <input type="file" name="featured_image_file" accept="image/*" class="admin-input">
        <label style="margin-top:.5rem">…or paste Featured Image URL</label>
        <input type="text" name="featured_image" value="<?= sanitize($item['featured_image']) ?>" class="admin-input" placeholder="https://...">
        <?php if (!empty($item['featured_image'])): ?><img src="<?= sanitize($item['featured_image']) ?>" alt="" style="margin-top:.5rem;max-height:64px;border-radius:6px"><?php endif; ?>
    </div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Hero Heading</label><input type="text" name="hero_heading" value="<?= sanitize($item['hero_heading']) ?>" class="admin-input"></div><div class="admin-form-group"><label>CTA Text</label><input type="text" name="cta_text" value="<?= sanitize($item['cta_text']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label>Hero Text</label><textarea name="hero_text" class="admin-input" rows="3"><?= sanitize($item['hero_text']) ?></textarea></div>
    <div class="admin-form-group"><label>Pain Points (JSON array)</label><textarea name="pain_points" class="admin-input" rows="3"><?= sanitize($item['pain_points']) ?></textarea></div>
    <div class="admin-form-group"><label>Benefits (JSON array)</label><textarea name="benefits" class="admin-input" rows="3"><?= sanitize($item['benefits']) ?></textarea></div>
    <div class="admin-form-group"><label>FAQs (JSON [{q,a}])</label><textarea name="faqs" class="admin-input" rows="3"><?= sanitize($item['faqs']) ?></textarea></div>
    <div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $item['sort_order'] ?>" class="admin-input"></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $item['is_active']?'checked':'' ?>> Active</label></div>
    <h3 style="margin:2rem 0 1rem">SEO</h3>
    <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($item['meta_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-input" rows="2"><?= sanitize($item['meta_description']) ?></textarea></div>
    <div class="admin-form-group"><label>Meta Keywords</label><input type="text" name="meta_keywords" value="<?= sanitize($item['meta_keywords']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Schema JSON</label><textarea name="schema_json" class="admin-input" rows="2"><?= sanitize($item['schema_json']) ?></textarea></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save</button><a href="/admin/?page=industries" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
