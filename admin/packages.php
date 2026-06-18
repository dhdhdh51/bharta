<?php
/**
 * Admin - Packages Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();
$action = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';
    if ($pa === 'save') {
        $data = [sanitize($_POST['package_name']??''), floatval($_POST['price']??0), $_POST['monthly_price']?floatval($_POST['monthly_price']):null, $_POST['features']??'[]', sanitize($_POST['delivery_time']??''), isset($_POST['is_highlighted'])?1:0, sanitize($_POST['cta_text']??'Get Started'), intval($_POST['sort_order']??0), isset($_POST['is_active'])?1:0];
        $id = intval($_POST['id']??0);
        if ($id) {
            $stmt = getDB()->prepare("UPDATE packages SET package_name=?,price=?,monthly_price=?,features=?,delivery_time=?,is_highlighted=?,cta_text=?,sort_order=?,is_active=? WHERE id=?");
            $stmt->execute([...$data, $id]);
        } else {
            $stmt = getDB()->prepare("INSERT INTO packages (package_name,price,monthly_price,features,delivery_time,is_highlighted,cta_text,sort_order,is_active) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute($data);
        }
        setFlash('success', 'Package saved.');
        redirect('/admin/?page=packages');
    }
    if ($pa === 'delete') { getDB()->prepare("DELETE FROM packages WHERE id=?")->execute([intval($_POST['id'])]); setFlash('success','Deleted.'); redirect('/admin/?page=packages'); }
}
require __DIR__ . '/admin-header.php';
?>
<?php if ($action === 'list'): ?>
<div class="admin-page-header"><h1 class="admin-page-title">Packages</h1><a href="/admin/?page=packages&action=add" class="admin-btn admin-btn-primary">Add Package</a></div>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>
<?php $items = getDB()->query("SELECT * FROM packages ORDER BY sort_order ASC")->fetchAll(); ?>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Price</th><th>Monthly</th><th>Highlighted</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($items as $i): ?>
<tr><td><?= sanitize($i['package_name']) ?></td><td><?= formatPrice($i['price']) ?></td><td><?= $i['monthly_price']?formatPrice($i['monthly_price']).'/mo':'-' ?></td><td><?= $i['is_highlighted']?'★':'' ?></td><td><?= $i['is_active']?'✓':'✕' ?></td><td><a href="/admin/?page=packages&action=edit&id=<?= $i['id'] ?>" class="admin-btn admin-btn-sm">Edit</a> <form method="POST" style="display:inline" onsubmit="return confirm('Delete?')"><input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $i['id'] ?>"><button class="admin-btn admin-btn-danger admin-btn-sm">Delete</button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<?php else: ?>
<?php
$item = ['package_name'=>'','price'=>0,'monthly_price'=>'','features'=>'[]','delivery_time'=>'','is_highlighted'=>0,'cta_text'=>'Get Started','sort_order'=>0,'is_active'=>1];
if ($editId) { $s=getDB()->prepare("SELECT * FROM packages WHERE id=?"); $s->execute([$editId]); $item=$s->fetch()?:$item; }
?>
<h1 class="admin-page-title"><?= $editId?'Edit':'Add' ?> Package</h1>
<form method="POST" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editId ?>">
    <div class="admin-form-grid"><div class="admin-form-group"><label>Package Name *</label><input type="text" name="package_name" value="<?= sanitize($item['package_name']) ?>" required class="admin-input"></div><div class="admin-form-group"><label>Price (₹)</label><input type="number" name="price" value="<?= $item['price'] ?>" class="admin-input" step="0.01"></div></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>Monthly Price (₹, optional)</label><input type="number" name="monthly_price" value="<?= $item['monthly_price'] ?>" class="admin-input" step="0.01"></div><div class="admin-form-group"><label>Delivery Time</label><input type="text" name="delivery_time" value="<?= sanitize($item['delivery_time']) ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label>Features (JSON array)</label><textarea name="features" class="admin-input" rows="4"><?= sanitize($item['features']) ?></textarea></div>
    <div class="admin-form-grid"><div class="admin-form-group"><label>CTA Text</label><input type="text" name="cta_text" value="<?= sanitize($item['cta_text']) ?>" class="admin-input"></div><div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $item['sort_order'] ?>" class="admin-input"></div></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_highlighted" <?= $item['is_highlighted']?'checked':'' ?>> Highlight as Popular</label></div>
    <div class="admin-form-group"><label><input type="checkbox" name="is_active" <?= $item['is_active']?'checked':'' ?>> Active</label></div>
    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save</button><a href="/admin/?page=packages" class="admin-btn">Cancel</a></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/admin-footer.php'; ?>
