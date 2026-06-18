<?php
/**
 * Bharat SEO - Diagnostics / Health Check
 *
 * Visit /health.php to see exactly what is or isn't working.
 * Delete this file once your site is running.
 */
@require_once __DIR__ . '/config.php';

$rows = [];
function check(string $label, bool $ok, string $detail = ''): void {
    global $rows;
    $rows[] = ['label' => $label, 'ok' => $ok, 'detail' => $detail];
}

// PHP version
$phpOk = version_compare(PHP_VERSION, '8.0.0', '>=');
check('PHP version ' . PHP_VERSION, $phpOk, $phpOk ? '' : 'PHP 8.0+ required');

// Extensions
check('PDO extension', extension_loaded('pdo'));
check('pdo_mysql extension', extension_loaded('pdo_mysql'),
    extension_loaded('pdo_mysql') ? '' : 'Enable pdo_mysql in your hosting PHP settings');

// Config constants
$cfg = defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER');
check('config.php loaded', $cfg, $cfg ? ('Host=' . DB_HOST . ', DB=' . DB_NAME . ', User=' . DB_USER) : 'config.php missing or invalid');

// mod_rewrite (best-effort detection)
$rewrite = function_exists('apache_get_modules') ? in_array('mod_rewrite', apache_get_modules()) : null;
if ($rewrite === null) {
    check('mod_rewrite', true, 'Could not auto-detect (normal on PHP-FPM/LiteSpeed). If /services 404s but / works, clean URLs are off.');
} else {
    check('mod_rewrite enabled', $rewrite, $rewrite ? '' : 'Clean URLs (/services, /admin) will not work without mod_rewrite');
}

// uploads dir writable
$uploadsDir = __DIR__ . '/uploads';
$uw = is_dir($uploadsDir) ? is_writable($uploadsDir) : @mkdir($uploadsDir, 0755, true);
check('uploads/ directory writable', (bool)$uw, $uw ? '' : 'Create an uploads/ folder and set permissions to 755');

// Database connection + tables
$dbConnected = false;
$pdo = null;
if ($cfg) {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
        $dbConnected = true;
        check('Database connection to `' . DB_NAME . '`', true);
    } catch (PDOException $e) {
        check('Database connection to `' . DB_NAME . '`', false,
            $e->getMessage() . ' — fix DB_* values in config.php, or run /install.php');
    }
}

// Required tables
if ($dbConnected) {
    $required = ['admin_users','site_settings','seo_settings','services','industries',
                 'packages','portfolio','case_studies','testimonials','blog_categories',
                 'blog_posts','leads','audit_requests','media'];
    $existing = [];
    foreach ($pdo->query("SHOW TABLES") as $r) { $existing[] = array_values($r)[0]; }
    $missing = array_diff($required, $existing);
    check('Database tables (' . count($existing) . ' found)', count($missing) === 0,
        $missing ? 'Missing: ' . implode(', ', $missing) . ' — run /install.php' : 'All required tables present');

    if (in_array('admin_users', $existing)) {
        $admin = $pdo->query("SELECT username FROM admin_users LIMIT 1")->fetch();
        check('Admin account exists', (bool)$admin, $admin ? 'Login at /admin/ with admin / admin123' : 'No admin row — run /install.php');
    }
}

$allOk = !in_array(false, array_column($rows, 'ok'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Health Check - Bharat SEO</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:-apple-system,'Inter',sans-serif;background:#F8FAFC;color:#101828;padding:40px 16px;line-height:1.6}
        .card{max-width:720px;margin:0 auto;background:#fff;border:1px solid #E5E7EB;border-radius:14px;padding:32px}
        h1{color:#071D49;font-size:1.5rem;margin-bottom:4px}
        .sub{color:#667085;margin-bottom:24px;font-size:.9rem}
        .row{display:flex;gap:12px;align-items:flex-start;padding:12px 0;border-bottom:1px solid #F1F5F9}
        .ic{flex-shrink:0;width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;color:#fff}
        .ic.ok{background:#16a34a}.ic.no{background:#dc2626}
        .lbl{font-weight:500}
        .detail{color:#667085;font-size:.82rem;word-break:break-word}
        .banner{margin-bottom:24px;padding:14px 16px;border-radius:8px;font-weight:600}
        .banner.good{background:#dcfce7;color:#166534}
        .banner.bad{background:#fee2e2;color:#991b1b}
        a{color:#1B66FF}
        .warn{margin-top:20px;font-size:.82rem;color:#92400e;background:#fef3c7;border:1px solid #fde68a;padding:12px;border-radius:8px}
    </style>
</head>
<body>
    <div class="card">
        <h1>Bharat SEO — Health Check</h1>
        <p class="sub">Diagnostics for your installation.</p>
        <div class="banner <?= $allOk ? 'good' : 'bad' ?>">
            <?= $allOk ? 'Everything looks good ✓' : 'Some checks failed — see details below' ?>
        </div>
        <?php foreach ($rows as $r): ?>
            <div class="row">
                <span class="ic <?= $r['ok'] ? 'ok' : 'no' ?>"><?= $r['ok'] ? '✓' : '✕' ?></span>
                <div>
                    <div class="lbl"><?= htmlspecialchars($r['label']) ?></div>
                    <?php if ($r['detail']): ?><div class="detail"><?= htmlspecialchars($r['detail']) ?></div><?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="warn">Delete <strong>health.php</strong> (and install.php) once your site is working.</div>
    </div>
</body>
</html>
