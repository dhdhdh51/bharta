<?php
/**
 * Admin - Blog Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';
    if ($pa === 'save') {
        $imgUp = handleImageUpload('featured_image_file');
        $data = [
            sanitize($_POST['title']??''),
            createSlug($_POST['slug']?:$_POST['title']),
            intval($_POST['category_id']??0) ?: null,
            sanitize($_POST['author']??'Bharat SEO Team'),
            ($imgUp ?: sanitize($_POST['featured_image']??'')),
            $_POST['content'] ?? '',
            sanitize($_POST['excerpt']??''),
            sanitize($_POST['meta_title']??''),
            sanitize($_POST['meta_description']??''),
            sanitize($_POST['meta_keywords']??''),
            sanitize($_POST['canonical_url']??''),
            $_POST['schema_json']??'',
            $_POST['faqs']??'',
            intval($_POST['related_service_id']??0) ?: null,
            intval($_POST['related_industry_id']??0) ?: null,
            $_POST['status']??'draft',
            $_POST['publish_date'] ?: date('Y-m-d H:i:s'),
        ];
        $id = intval($_POST['id']??0);
        if ($id) {
            getDB()->prepare("UPDATE blog_posts SET title=?,slug=?,category_id=?,author=?,featured_image=?,content=?,excerpt=?,meta_title=?,meta_description=?,meta_keywords=?,canonical_url=?,schema_json=?,faqs=?,related_service_id=?,related_industry_id=?,status=?,publish_date=? WHERE id=?")->execute([...$data,$id]);
        } else {
            getDB()->prepare("INSERT INTO blog_posts (title,slug,category_id,author,featured_image,content,excerpt,meta_title,meta_description,meta_keywords,canonical_url,schema_json,faqs,related_service_id,related_industry_id,status,publish_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute($data);
        }
        setFlash('success', 'Post saved.');
        redirect('/admin/?page=blog');
    }
    if ($pa === 'delete') { getDB()->prepare("DELETE FROM blog_posts WHERE id=?")->execute([intval($_POST['id'])]); setFlash('success','Deleted.'); redirect('/admin/?page=blog'); }
}

$categories = getDB()->query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();
$services = getDB()->query("SELECT id, title FROM services WHERE is_active=1")->fetchAll();
$industries = getDB()->query("SELECT id, title FROM industries WHERE is_active=1")->fetchAll();

require __DIR__ . '/admin-header.php';
?>
<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Blog Posts</h1><a href="/admin/?page=blog&action=add" class="admin-btn admin-btn-primary">New Post</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $posts = getDB()->query("SELECT bp.*, bc.name as cat_name FROM blog_posts bp LEFT JOIN blog_categories bc ON bp.category_id=bc.id ORDER BY bp.created_at DESC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Views</th><th>Date</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($posts as $p): ?>
<tr><td><strong><?= sanitize($p['title']) ?></strong><br><small>/blog/<?= sanitize($p['slug']) ?></small></td><td><?= sanitize($p['cat_name']??'-') ?></td><td><span class="admin-badge admin-badge-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td><td><?= $p['views'] ?></td><td><?= $p['publish_date']?date('M j, Y',strtotime($p['publish_date'])):'-' ?></td><td><a href="/admin/?page=blog&action=edit&id=<?= $p['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<?php else: ?>
<?php
$item = ['title'=>'','slug'=>'','category_id'=>'','author'=>'Bharat SEO Team','featured_image'=>'','content'=>'','excerpt'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','canonical_url'=>'','schema_json'=>'','faqs'=>'','related_service_id'=>'','related_industry_id'=>'','status'=>'draft','publish_date'=>date('Y-m-d H:i:s')];
if ($editId) { $s=getDB()->prepare("SELECT * FROM blog_posts WHERE id=?"); $s->execute([$editId]); $item=$s->fetch()?:$item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'New' ?> Blog Post</h1>
<form method="POST" class="admin-form" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-group"><label>Title *</label><input type="text" name="title" value="<?= sanitize($item['title']) ?>" required class="admin-input"></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Slug</label><input type="text" name="slug" value="<?= sanitize($item['slug']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Author</label><input type="text" name="author" value="<?= sanitize($item['author']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Category</label><select name="category_id" class="admin-input"><option value="">None</option><?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= $item['category_id']==$c['id']?'selected':'' ?>><?= sanitize($c['name']) ?></option><?php endforeach; ?></select></div>
        <div class="admin-form-group"><label>Status</label><select name="status" class="admin-input"><option value="draft" <?= $item['status']==='draft'?'selected':'' ?>>Draft</option><option value="published" <?= $item['status']==='published'?'selected':'' ?>>Published</option></select></div>
    </div>
    <div class="admin-form-grid">
        <div class="admin-form-group">
            <label>Featured Image — Upload image</label>
            <input type="file" name="featured_image_file" accept="image/*" class="admin-input">
            <label style="margin-top:.5rem">…or paste Featured Image URL</label>
            <input type="text" name="featured_image" value="<?= sanitize($item['featured_image']) ?>" class="admin-input" placeholder="https://...">
            <?php if (!empty($item['featured_image'])): ?><img src="<?= sanitize($item['featured_image']) ?>" alt="" style="margin-top:.5rem;max-height:64px;border-radius:6px"><?php endif; ?>
        </div>
        <div class="admin-form-group"><label>Publish Date</label><input type="datetime-local" name="publish_date" value="<?= date('Y-m-d\TH:i', strtotime($item['publish_date'])) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-group"><label>Excerpt</label><textarea name="excerpt" class="admin-input" rows="2"><?= sanitize($item['excerpt']) ?></textarea></div>
    <div class="admin-form-group"><label>Content (HTML)</label><textarea name="content" class="admin-input" rows="15"><?= htmlspecialchars($item['content']) ?></textarea></div>
    <div class="admin-form-group"><label>FAQs (JSON [{q,a}])</label><textarea name="faqs" class="admin-input" rows="3"><?= sanitize($item['faqs']) ?></textarea></div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Related Service</label><select name="related_service_id" class="admin-input"><option value="">None</option><?php foreach ($services as $sv): ?><option value="<?= $sv['id'] ?>" <?= $item['related_service_id']==$sv['id']?'selected':'' ?>><?= sanitize($sv['title']) ?></option><?php endforeach; ?></select></div>
        <div class="admin-form-group"><label>Related Industry</label><select name="related_industry_id" class="admin-input"><option value="">None</option><?php foreach ($industries as $ind): ?><option value="<?= $ind['id'] ?>" <?= $item['related_industry_id']==$ind['id']?'selected':'' ?>><?= sanitize($ind['title']) ?></option><?php endforeach; ?></select></div>
    </div>
    <h3 style="margin:2rem 0 1rem">SEO</h3>
    <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($item['meta_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-input" rows="2"><?= sanitize($item['meta_description']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Meta Keywords</label><input type="text" name="meta_keywords" value="<?= sanitize($item['meta_keywords']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Canonical URL</label><input type="text" name="canonical_url" value="<?= sanitize($item['canonical_url']) ?>" class="admin-input"></div></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save Post</button><a href="/admin/?page=blog" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
