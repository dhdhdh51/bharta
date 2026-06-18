<?php
/**
 * Admin - Case Studies Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';
    if ($pa === 'save') {
        $imgUp = handleImageUpload('featured_image_file');
        $data = [sanitize($_POST['title']??''), createSlug($_POST['slug']?:$_POST['title']), sanitize($_POST['client_name']??''), sanitize($_POST['industry']??''), sanitize($_POST['city']??''), sanitize($_POST['challenge']??''), sanitize($_POST['strategy']??''), sanitize($_POST['work_done']??''), sanitize($_POST['result_summary']??''), ($imgUp ?: sanitize($_POST['featured_image']??'')), $_POST['gallery']??'', sanitize($_POST['website_url']??''), sanitize($_POST['google_maps_link']??''), isset($_POST['is_active'])?1:0, sanitize($_POST['meta_title']??''), sanitize($_POST['meta_description']??''), $_POST['schema_json']??''];
        $id = intval($_POST['id']??0);
        if ($id) {
            getDB()->prepare("UPDATE case_studies SET title=?,slug=?,client_name=?,industry=?,city=?,challenge=?,strategy=?,work_done=?,result_summary=?,featured_image=?,gallery=?,website_url=?,google_maps_link=?,is_active=?,meta_title=?,meta_description=?,schema_json=? WHERE id=?")->execute([...$data,$id]);
        } else {
            getDB()->prepare("INSERT INTO case_studies (title,slug,client_name,industry,city,challenge,strategy,work_done,result_summary,featured_image,gallery,website_url,google_maps_link,is_active,meta_title,meta_description,schema_json) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute($data);
        }
        setFlash('success', 'Case study saved.');
        redirect('/admin/?page=case-studies');
    }
    if ($pa === 'delete') { getDB()->prepare("DELETE FROM case_studies WHERE id=?")->execute([intval($_POST['id'])]); setFlash('success','Deleted.'); redirect('/admin/?page=case-studies'); }
}
require __DIR__ . '/admin-header.php';
?>
<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Case Studies</h1><a href="/admin/?page=case-studies&action=add" class="admin-btn admin-btn-primary">Add Case Study</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $items = getDB()->query("SELECT * FROM case_studies ORDER BY created_at DESC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Industry</th><th>City</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($items as $i): ?>
<tr><td><?= sanitize($i['title']) ?></td><td><?= sanitize($i['industry']??'-') ?></td><td><?= sanitize($i['city']??'-') ?></td><td><?= $i['is_active']?'✓':'✕' ?></td><td><a href="/admin/?page=case-studies&action=edit&id=<?= $i['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $i['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<?php else: ?>
<?php
$item = ['title'=>'','slug'=>'','client_name'=>'','industry'=>'','city'=>'','challenge'=>'','strategy'=>'','work_done'=>'','result_summary'=>'','featured_image'=>'','gallery'=>'','website_url'=>'','google_maps_link'=>'','is_active'=>1,'meta_title'=>'','meta_description'=>'','schema_json'=>''];
if ($editId) { $s=getDB()->prepare("SELECT * FROM case_studies WHERE id=?"); $s->execute([$editId]); $item=$s->fetch()?:$item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'Add' ?> Case Study</h1>
<form method="POST" class="admin-form" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-grid"><div class="admin-form-group"><label>Title *</label><input type="text" name="title" value="<?= sanitize($item['title']) ?>" required class="admin-input"></div><div class="admin-form-group"><label>Slug</label><input type="text" name="slug" value="<?= sanitize($item['slug']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Client Name</label><input type="text" name="client_name" value="<?= sanitize($item['client_name']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Industry</label><input type="text" name="industry" value="<?= sanitize($item['industry']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label>City</label><input type="text" name="city" value="<?= sanitize($item['city']) ?>" class="admin-input"></div>
    <div class="admin-form-group">
        <label>Featured Image — Upload image</label>
        <input type="file" name="featured_image_file" accept="image/*" class="admin-input">
        <label style="margin-top:.5rem">…or paste Featured Image URL</label>
        <input type="text" name="featured_image" value="<?= sanitize($item['featured_image']) ?>" class="admin-input" placeholder="https://...">
        <?php if (!empty($item['featured_image'])): ?><img src="<?= sanitize($item['featured_image']) ?>" alt="" style="margin-top:.5rem;max-height:64px;border-radius:6px"><?php endif; ?>
    </div>
    <div class="admin-form-group"><label>Challenge</label><textarea name="challenge" class="admin-input" rows="3"><?= sanitize($item['challenge']) ?></textarea></div>
    <div class="admin-form-group"><label>Strategy</label><textarea name="strategy" class="admin-input" rows="3"><?= sanitize($item['strategy']) ?></textarea></div>
    <div class="admin-form-group"><label>Work Done</label><textarea name="work_done" class="admin-input" rows="3"><?= sanitize($item['work_done']) ?></textarea></div>
    <div class="admin-form-group"><label>Result Summary</label><textarea name="result_summary" class="admin-input" rows="3"><?= sanitize($item['result_summary']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Website URL</label><input type="url" name="website_url" value="<?= sanitize($item['website_url']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Google Maps Link</label><input type="url" name="google_maps_link" value="<?= sanitize($item['google_maps_link']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $item['is_active']?'checked':'' ?>> Active</label></div>
    <h3 style="margin:2rem 0 1rem">SEO</h3>
    <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($item['meta_title']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-input" rows="2"><?= sanitize($item['meta_description']) ?></textarea></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save</button><a href="/admin/?page=case-studies" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
