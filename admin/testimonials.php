<?php
/**
 * Admin - Testimonials Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';
    if ($pa === 'save') {
        $imgUp = handleImageUpload('photo_file');
        $data = [sanitize($_POST['client_name']??''), sanitize($_POST['business_name']??''), sanitize($_POST['business_category']??''), sanitize($_POST['city']??''), ($imgUp ?: sanitize($_POST['photo']??'')), intval($_POST['rating']??5), sanitize($_POST['review']??''), sanitize($_POST['video_url']??''), isset($_POST['is_active'])?1:0, intval($_POST['sort_order']??0)];
        $id = intval($_POST['id']??0);
        if ($id) {
            getDB()->prepare("UPDATE testimonials SET client_name=?,business_name=?,business_category=?,city=?,photo=?,rating=?,review=?,video_url=?,is_active=?,sort_order=? WHERE id=?")->execute([...$data,$id]);
        } else {
            getDB()->prepare("INSERT INTO testimonials (client_name,business_name,business_category,city,photo,rating,review,video_url,is_active,sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)")->execute($data);
        }
        setFlash('success', 'Testimonial saved.');
        redirect('/admin/?page=testimonials');
    }
    if ($pa === 'delete') { getDB()->prepare("DELETE FROM testimonials WHERE id=?")->execute([intval($_POST['id'])]); setFlash('success','Deleted.'); redirect('/admin/?page=testimonials'); }
}
require __DIR__ . '/admin-header.php';
?>
<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Testimonials</h1><a href="/admin/?page=testimonials&action=add" class="admin-btn admin-btn-primary">Add Testimonial</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $items = getDB()->query("SELECT * FROM testimonials ORDER BY sort_order ASC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Client</th><th>Business</th><th>City</th><th>Rating</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($items as $i): ?>
<tr><td><?= sanitize($i['client_name']) ?></td><td><?= sanitize($i['business_name']??'-') ?></td><td><?= sanitize($i['city']??'-') ?></td><td><?= str_repeat('★',$i['rating']) ?></td><td><?= $i['is_active']?'✓':'✕' ?></td><td><a href="/admin/?page=testimonials&action=edit&id=<?= $i['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $i['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<?php else: ?>
<?php
$item = ['client_name'=>'','business_name'=>'','business_category'=>'','city'=>'','photo'=>'','rating'=>5,'review'=>'','video_url'=>'','is_active'=>1,'sort_order'=>0];
if ($editId) { $s=getDB()->prepare("SELECT * FROM testimonials WHERE id=?"); $s->execute([$editId]); $item=$s->fetch()?:$item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'Add' ?> Testimonial</h1>
<form method="POST" class="admin-form" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-grid"><div class="admin-form-group"><label>Client Name *</label><input type="text" name="client_name" value="<?= sanitize($item['client_name']) ?>" required class="admin-input"></div><div class="admin-form-group"><label>Business Name</label><input type="text" name="business_name" value="<?= sanitize($item['business_name']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Business Category</label><input type="text" name="business_category" value="<?= sanitize($item['business_category']) ?>" class="admin-input"></div><div class="admin-form-group"><label>City</label><input type="text" name="city" value="<?= sanitize($item['city']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid">
        <div class="admin-form-group">
            <label>Photo — Upload image</label>
            <input type="file" name="photo_file" accept="image/*" class="admin-input">
            <label style="margin-top:.5rem">…or paste Photo URL</label>
            <input type="text" name="photo" value="<?= sanitize($item['photo']) ?>" class="admin-input" placeholder="https://...">
            <?php if (!empty($item['photo'])): ?><img src="<?= sanitize($item['photo']) ?>" alt="" style="margin-top:.5rem;max-height:56px;border-radius:50%"><?php endif; ?>
        </div>
        <div class="admin-form-group"><label>Rating (1-5)</label><input type="number" name="rating" value="<?= $item['rating'] ?>" min="1" max="5" class="admin-input"></div>
    </div>
    <div class="admin-form-group"><label>Review *</label><textarea name="review" class="admin-input" rows="4" required><?= sanitize($item['review']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Video URL (optional)</label><input type="url" name="video_url" value="<?= sanitize($item['video_url']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $item['sort_order'] ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $item['is_active']?'checked':'' ?>> Active</label></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save</button><a href="/admin/?page=testimonials" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
