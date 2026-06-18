<?php
/**
 * Admin - Portfolio Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';
    if ($pa === 'save') {
        $data = [sanitize($_POST['title']??''), sanitize($_POST['client_name']??''), sanitize($_POST['industry']??''), sanitize($_POST['screenshot']??''), sanitize($_POST['project_url']??''), sanitize($_POST['summary']??''), sanitize($_POST['tags']??''), intval($_POST['sort_order']??0), isset($_POST['is_active'])?1:0];
        $id = intval($_POST['id']??0);
        if ($id) {
            getDB()->prepare("UPDATE portfolio SET title=?,client_name=?,industry=?,screenshot=?,project_url=?,summary=?,tags=?,sort_order=?,is_active=? WHERE id=?")->execute([...$data,$id]);
        } else {
            getDB()->prepare("INSERT INTO portfolio (title,client_name,industry,screenshot,project_url,summary,tags,sort_order,is_active) VALUES (?,?,?,?,?,?,?,?,?)")->execute($data);
        }
        setFlash('success', 'Project saved.');
        redirect('/admin/?page=portfolio');
    }
    if ($pa === 'delete') { getDB()->prepare("DELETE FROM portfolio WHERE id=?")->execute([intval($_POST['id'])]); setFlash('success','Deleted.'); redirect('/admin/?page=portfolio'); }
}
require __DIR__ . '/admin-header.php';
?>
<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Portfolio</h1><a href="/admin/?page=portfolio&action=add" class="admin-btn admin-btn-primary">Add Project</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $items = getDB()->query("SELECT * FROM portfolio ORDER BY sort_order ASC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Client</th><th>Industry</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($items as $i): ?>
<tr><td><?= sanitize($i['title']) ?></td><td><?= sanitize($i['client_name']??'-') ?></td><td><?= sanitize($i['industry']??'-') ?></td><td><?= $i['is_active']?'✓':'✕' ?></td><td><a href="/admin/?page=portfolio&action=edit&id=<?= $i['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $i['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<?php else: ?>
<?php
$item = ['title'=>'','client_name'=>'','industry'=>'','screenshot'=>'','project_url'=>'','summary'=>'','tags'=>'','sort_order'=>0,'is_active'=>1];
if ($editId) { $s=getDB()->prepare("SELECT * FROM portfolio WHERE id=?"); $s->execute([$editId]); $item=$s->fetch()?:$item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'Add' ?> Project</h1>
<form method="POST" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-grid"><div class="admin-form-group"><label>Title *</label><input type="text" name="title" value="<?= sanitize($item['title']) ?>" required class="admin-input"></div><div class="admin-form-group"><label>Client Name</label><input type="text" name="client_name" value="<?= sanitize($item['client_name']) ?>" class="admin-input"></div></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Industry</label><input type="text" name="industry" value="<?= sanitize($item['industry']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Project URL</label><input type="url" name="project_url" value="<?= sanitize($item['project_url']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label>Screenshot URL</label><input type="text" name="screenshot" value="<?= sanitize($item['screenshot']) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Summary</label><textarea name="summary" class="admin-input" rows="3"><?= sanitize($item['summary']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Tags (comma-separated)</label><input type="text" name="tags" value="<?= sanitize($item['tags']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $item['sort_order'] ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $item['is_active']?'checked':'' ?>> Active</label></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save</button><a href="/admin/?page=portfolio" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
