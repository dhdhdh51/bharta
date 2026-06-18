<?php
/**
 * Admin Dashboard
 */
$totalLeads = getDB()->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$newLeads = getDB()->query("SELECT COUNT(*) FROM leads WHERE status = 'new'")->fetchColumn();
$totalAudits = getDB()->query("SELECT COUNT(*) FROM audit_requests")->fetchColumn();
$newAudits = getDB()->query("SELECT COUNT(*) FROM audit_requests WHERE status = 'new'")->fetchColumn();
$totalServices = getDB()->query("SELECT COUNT(*) FROM services WHERE is_active = 1")->fetchColumn();
$totalPosts = getDB()->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'")->fetchColumn();
$totalCases = getDB()->query("SELECT COUNT(*) FROM case_studies WHERE is_active = 1")->fetchColumn();

$recentLeads = getDB()->query("SELECT * FROM leads ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recentAudits = getDB()->query("SELECT * FROM audit_requests ORDER BY created_at DESC LIMIT 5")->fetchAll();

require __DIR__ . '/admin-header.php';
?>

<h1 class="admin-page-title">Dashboard</h1>

<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= $totalLeads ?></div>
        <div class="admin-stat-label">Total Enquiries</div>
    </div>
    <div class="admin-stat-card admin-stat-highlight">
        <div class="admin-stat-value"><?= $newLeads ?></div>
        <div class="admin-stat-label">New Enquiries</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= $totalAudits ?></div>
        <div class="admin-stat-label">Audit Requests</div>
    </div>
    <div class="admin-stat-card admin-stat-highlight">
        <div class="admin-stat-value"><?= $newAudits ?></div>
        <div class="admin-stat-label">New Audits</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= $totalServices ?></div>
        <div class="admin-stat-label">Active Services</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= $totalPosts ?></div>
        <div class="admin-stat-label">Blog Posts</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= $totalCases ?></div>
        <div class="admin-stat-label">Case Studies</div>
    </div>
</div>

<div class="admin-quick-actions">
    <a href="/admin/?page=leads" class="admin-btn admin-btn-primary">View Leads</a>
    <a href="/admin/?page=audit-requests" class="admin-btn admin-btn-primary">View Audits</a>
    <a href="/admin/?page=blog&action=add" class="admin-btn">New Blog Post</a>
    <a href="/admin/?page=services&action=add" class="admin-btn">Add Service</a>
</div>

<!-- Recent Leads -->
<div class="admin-section">
    <h2 class="admin-section-title">Recent Leads</h2>
    <?php if ($recentLeads): ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Name</th><th>Business</th><th>Phone</th><th>City</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php foreach ($recentLeads as $lead): ?>
                <tr>
                    <td><?= sanitize($lead['name']) ?></td>
                    <td><?= sanitize($lead['business_name'] ?? '-') ?></td>
                    <td><?= sanitize($lead['phone'] ?? '-') ?></td>
                    <td><?= sanitize($lead['city'] ?? '-') ?></td>
                    <td><span class="admin-badge admin-badge-<?= $lead['status'] ?>"><?= ucfirst($lead['status']) ?></span></td>
                    <td><?= date('M j', strtotime($lead['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="admin-empty">No leads yet.</p>
    <?php endif; ?>
</div>

<!-- Recent Audit Requests -->
<div class="admin-section">
    <h2 class="admin-section-title">Recent Audit Requests</h2>
    <?php if ($recentAudits): ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Name</th><th>Business</th><th>Type</th><th>City</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php foreach ($recentAudits as $audit): ?>
                <tr>
                    <td><?= sanitize($audit['name']) ?></td>
                    <td><?= sanitize($audit['business_name'] ?? '-') ?></td>
                    <td><?= sanitize($audit['business_type'] ?? '-') ?></td>
                    <td><?= sanitize($audit['city'] ?? '-') ?></td>
                    <td><span class="admin-badge admin-badge-<?= $audit['status'] ?>"><?= ucfirst($audit['status']) ?></span></td>
                    <td><?= date('M j', strtotime($audit['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="admin-empty">No audit requests yet.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/admin-footer.php'; ?>
