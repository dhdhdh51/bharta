<?php
/**
 * Admin - Leads & Enquiries Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if ($action === 'update_status' && $id) {
        $status = $_POST['status'] ?? 'new';
        $notes = $_POST['notes'] ?? '';
        $followUp = $_POST['follow_up_date'] ?? null;
        $stmt = getDB()->prepare("UPDATE leads SET status = ?, notes = ?, follow_up_date = ? WHERE id = ?");
        $stmt->execute([$status, $notes, $followUp ?: null, $id]);
        setFlash('success', 'Lead updated successfully.');
        redirect('/admin/?page=leads');
    }

    if ($action === 'delete' && $id) {
        $stmt = getDB()->prepare("DELETE FROM leads WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Lead deleted.');
        redirect('/admin/?page=leads');
    }
}

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="leads_export_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Business', 'Phone', 'Email', 'Type', 'City', 'Message', 'Status', 'Source', 'Date']);
    $rows = getDB()->query("SELECT * FROM leads ORDER BY created_at DESC")->fetchAll();
    foreach ($rows as $row) {
        fputcsv($output, [$row['name'], $row['business_name'], $row['phone'], $row['email'], $row['business_type'], $row['city'], $row['message'], $row['status'], $row['utm_source'], $row['created_at']]);
    }
    fclose($output);
    exit;
}

// Filters
$statusFilter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

$where = "1=1";
$params = [];
if ($statusFilter) { $where .= " AND status = ?"; $params[] = $statusFilter; }
if ($search) { $where .= " AND (name LIKE ? OR business_name LIKE ? OR phone LIKE ? OR city LIKE ?)"; $params = array_merge($params, ["%$search%", "%$search%", "%$search%", "%$search%"]); }

$stmt = getDB()->prepare("SELECT * FROM leads WHERE $where ORDER BY created_at DESC");
$stmt->execute($params);
$leads = $stmt->fetchAll();

require __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <h1 class="admin-page-title">Leads & Enquiries</h1>
    <a href="/admin/?page=leads&export=csv" class="admin-btn">Export CSV</a>
</div>

<?php if ($flash): ?>
<div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div>
<?php endif; ?>

<!-- Filters -->
<div class="admin-filters">
    <form method="GET" class="admin-filter-form">
        <input type="hidden" name="page" value="leads">
        <input type="text" name="search" placeholder="Search name, business, phone, city..." value="<?= sanitize($search) ?>" class="admin-input">
        <select name="status" class="admin-input">
            <option value="">All Status</option>
            <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>New</option>
            <option value="contacted" <?= $statusFilter === 'contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="interested" <?= $statusFilter === 'interested' ? 'selected' : '' ?>>Interested</option>
            <option value="follow_up" <?= $statusFilter === 'follow_up' ? 'selected' : '' ?>>Follow Up</option>
            <option value="converted" <?= $statusFilter === 'converted' ? 'selected' : '' ?>>Converted</option>
            <option value="not_interested" <?= $statusFilter === 'not_interested' ? 'selected' : '' ?>>Not Interested</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
    </form>
</div>

<!-- Leads Table -->
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr><th>Name</th><th>Business</th><th>Phone</th><th>City</th><th>Type</th><th>Status</th><th>Source</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if ($leads): ?>
            <?php foreach ($leads as $lead): ?>
            <tr>
                <td><strong><?= sanitize($lead['name']) ?></strong><br><small><?= sanitize($lead['email'] ?? '') ?></small></td>
                <td><?= sanitize($lead['business_name'] ?? '-') ?></td>
                <td><a href="tel:<?= sanitize($lead['phone']) ?>"><?= sanitize($lead['phone'] ?? '-') ?></a></td>
                <td><?= sanitize($lead['city'] ?? '-') ?></td>
                <td><?= sanitize($lead['business_type'] ?? '-') ?></td>
                <td><span class="admin-badge admin-badge-<?= $lead['status'] ?>"><?= ucfirst(str_replace('_', ' ', $lead['status'])) ?></span></td>
                <td><small><?= sanitize($lead['utm_source'] ?? '-') ?></small></td>
                <td><?= date('M j, Y', strtotime($lead['created_at'])) ?></td>
                <td>
                    <details class="admin-dropdown">
                        <summary class="admin-btn admin-btn-sm">Manage</summary>
                        <div class="admin-dropdown-content">
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                                <select name="status" class="admin-input" style="margin-bottom: 0.5rem;">
                                    <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>New</option>
                                    <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                    <option value="interested" <?= $lead['status'] === 'interested' ? 'selected' : '' ?>>Interested</option>
                                    <option value="follow_up" <?= $lead['status'] === 'follow_up' ? 'selected' : '' ?>>Follow Up</option>
                                    <option value="converted" <?= $lead['status'] === 'converted' ? 'selected' : '' ?>>Converted</option>
                                    <option value="not_interested" <?= $lead['status'] === 'not_interested' ? 'selected' : '' ?>>Not Interested</option>
                                </select>
                                <textarea name="notes" placeholder="Notes..." class="admin-input" style="margin-bottom: 0.5rem;"><?= sanitize($lead['notes'] ?? '') ?></textarea>
                                <input type="date" name="follow_up_date" class="admin-input" value="<?= $lead['follow_up_date'] ?? '' ?>" style="margin-bottom: 0.5rem;">
                                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Update</button>
                            </form>
                            <form method="POST" style="margin-top: 0.5rem;" onsubmit="return confirm('Delete this lead?')">
                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </div>
                    </details>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="9" class="admin-empty">No leads found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/admin-footer.php'; ?>
