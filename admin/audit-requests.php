<?php
/**
 * Admin - Audit Requests Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if ($action === 'update_status' && $id) {
        $stmt = getDB()->prepare("UPDATE audit_requests SET status = ?, audit_notes = ?, recommended_package = ?, follow_up_date = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['audit_notes'] ?? '', $_POST['recommended_package'] ?? '', $_POST['follow_up_date'] ?: null, $id]);
        setFlash('success', 'Audit request updated.');
        redirect('/admin/?page=audit-requests');
    }
    if ($action === 'delete' && $id) {
        getDB()->prepare("DELETE FROM audit_requests WHERE id = ?")->execute([$id]);
        setFlash('success', 'Request deleted.');
        redirect('/admin/?page=audit-requests');
    }
}

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="audit_requests_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name','Business','Phone','WhatsApp','Email','Type','City','Website','Status','Date']);
    $rows = getDB()->query("SELECT * FROM audit_requests ORDER BY created_at DESC")->fetchAll();
    foreach ($rows as $r) { fputcsv($output, [$r['name'],$r['business_name'],$r['phone'],$r['whatsapp_number'],$r['email'],$r['business_type'],$r['city'],$r['website_url'],$r['status'],$r['created_at']]); }
    fclose($output);
    exit;
}

$search = $_GET['search'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$where = "1=1";
$params = [];
if ($statusFilter) { $where .= " AND status = ?"; $params[] = $statusFilter; }
if ($search) { $where .= " AND (name LIKE ? OR business_name LIKE ? OR phone LIKE ? OR city LIKE ?)"; $params = array_merge($params, ["%$search%","%$search%","%$search%","%$search%"]); }

$stmt = getDB()->prepare("SELECT * FROM audit_requests WHERE $where ORDER BY created_at DESC");
$stmt->execute($params);
$audits = $stmt->fetchAll();

require __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <h1 class="admin-page-title">Free Audit Requests</h1>
    <a href="/admin/?page=audit-requests&export=csv" class="admin-btn">Export CSV</a>
</div>

<?php if ($flash): ?>
<div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div>
<?php endif; ?>

<div class="admin-filters">
    <form method="GET" class="admin-filter-form">
        <input type="hidden" name="page" value="audit-requests">
        <input type="text" name="search" placeholder="Search..." value="<?= sanitize($search) ?>" class="admin-input">
        <select name="status" class="admin-input">
            <option value="">All Status</option>
            <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>New</option>
            <option value="auditing" <?= $statusFilter === 'auditing' ? 'selected' : '' ?>>Auditing</option>
            <option value="contacted" <?= $statusFilter === 'contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="interested" <?= $statusFilter === 'interested' ? 'selected' : '' ?>>Interested</option>
            <option value="converted" <?= $statusFilter === 'converted' ? 'selected' : '' ?>>Converted</option>
            <option value="not_interested" <?= $statusFilter === 'not_interested' ? 'selected' : '' ?>>Not Interested</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
    </form>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Business</th><th>Phone</th><th>Type</th><th>City</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($audits as $a): ?>
            <tr>
                <td><strong><?= sanitize($a['name']) ?></strong></td>
                <td><?= sanitize($a['business_name'] ?? '-') ?></td>
                <td><a href="tel:<?= sanitize($a['phone']) ?>"><?= sanitize($a['phone']) ?></a></td>
                <td><?= sanitize($a['business_type'] ?? '-') ?></td>
                <td><?= sanitize($a['city'] ?? '-') ?></td>
                <td><span class="admin-badge admin-badge-<?= $a['status'] ?>"><?= ucfirst($a['status']) ?></span></td>
                <td><?= date('M j', strtotime($a['created_at'])) ?></td>
                <td>
                    <details class="admin-dropdown">
                        <summary class="admin-btn admin-btn-sm">Manage</summary>
                        <div class="admin-dropdown-content">
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                <select name="status" class="admin-input" style="margin-bottom:0.5rem">
                                    <?php foreach (['new','auditing','contacted','interested','converted','not_interested'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $a['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <textarea name="audit_notes" placeholder="Audit notes..." class="admin-input" style="margin-bottom:0.5rem"><?= sanitize($a['audit_notes'] ?? '') ?></textarea>
                                <input type="text" name="recommended_package" placeholder="Recommended package" class="admin-input" value="<?= sanitize($a['recommended_package'] ?? '') ?>" style="margin-bottom:0.5rem">
                                <input type="date" name="follow_up_date" class="admin-input" value="<?= $a['follow_up_date'] ?? '' ?>" style="margin-bottom:0.5rem">
                                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Update</button>
                            </form>
                            <form method="POST" style="margin-top:0.5rem" onsubmit="return confirm('Delete?')">
                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </div>
                    </details>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$audits): ?><tr><td colspan="8" class="admin-empty">No audit requests found.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/admin-footer.php'; ?>
