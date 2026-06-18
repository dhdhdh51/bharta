<?php
/**
 * Bharat SEO - One-Click Installer
 *
 * Creates the database, all tables and seed data from database.sql.
 * Visit /install.php in your browser, click "Run Installation".
 *
 * SECURITY: Delete this file after a successful installation.
 */
require_once __DIR__ . '/config.php';

$steps = [];
$ok = true;
$run = ($_SERVER['REQUEST_METHOD'] === 'POST');

function step(string $label, bool $success, string $detail = ''): void {
    global $steps, $ok;
    if (!$success) $ok = false;
    $steps[] = ['label' => $label, 'ok' => $success, 'detail' => $detail];
}

if ($run) {
    // 1. Connect to MySQL. On shared hosting the database is usually created in
    //    cPanel and the DB user has no CREATE DATABASE privilege, so we connect
    //    directly to DB_NAME. We fall back to a server-level connection (which can
    //    create the database) for local/VPS setups.
    $pdo = null;
    $dbExists = false;
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $dbExists = true;
        step('Connected to existing database `' . DB_NAME . '`', true);
    } catch (PDOException $e) {
        // Database may not exist yet — try connecting to the server to create it.
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            step('Connected to MySQL server (' . DB_HOST . ')', true);
            try {
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $pdo->exec("USE `" . DB_NAME . "`");
                $dbExists = true;
                step('Created database `' . DB_NAME . '`', true);
            } catch (PDOException $e2) {
                step('Create database `' . DB_NAME . '`', false,
                    $e2->getMessage() . ' — on shared hosting, create the database in '
                    . 'cPanel/Plesk first, then set its exact name in config.php (DB_NAME).');
            }
        } catch (PDOException $e3) {
            step('Connect to database', false, $e3->getMessage()
                . ' — check DB_HOST / DB_USER / DB_PASS / DB_NAME in config.php');
        }
    }

    // 2. Read database.sql and run only the table/seed statements (skip the
    //    CREATE DATABASE / USE lines which require elevated privileges).
    if ($pdo && $dbExists) {
        $sqlFile = __DIR__ . '/database.sql';
        if (!is_readable($sqlFile)) {
            step('Read database.sql', false, 'File not found or not readable at ' . $sqlFile);
        } else {
            $sql = file_get_contents($sqlFile);
            // Strip the leading CREATE DATABASE / USE statements.
            $sql = preg_replace('/^\s*CREATE\s+DATABASE[^;]*;/im', '', $sql);
            $sql = preg_replace('/^\s*USE\s+`?[A-Za-z0-9_]+`?\s*;/im', '', $sql);
            step('Read database.sql (' . number_format(strlen($sql)) . ' bytes)', true);
            try {
                $pdo->exec("USE `" . DB_NAME . "`");
                $pdo->exec($sql); // PDO_MYSQL supports multiple statements in one exec()
                step('Created tables and inserted seed data', true);
            } catch (PDOException $e) {
                step('Create tables / seed data', false, $e->getMessage());
            }
        }
    }

    // 3. Verify by connecting to the new database and counting key tables
    if ($ok) {
        try {
            $db = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );

            $checks = [
                'admin_users' => 'Admin user',
                'services' => 'Services',
                'industries' => 'Industries',
                'packages' => 'Packages',
                'site_settings' => 'Site settings',
                'seo_settings' => 'SEO settings',
            ];
            foreach ($checks as $table => $label) {
                $count = (int)$db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                step("Table `$table` ready ($count rows)", $count >= 0);
            }

            // Verify admin login works
            $admin = $db->query("SELECT username FROM admin_users WHERE username = 'admin'")->fetch();
            step('Default admin account present', (bool)$admin,
                $admin ? 'Login: admin / admin123 (you will be asked to change it)' : 'admin row missing');
        } catch (PDOException $e) {
            step('Verify installed database', false, $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Install - Bharat SEO</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',-apple-system,sans-serif;background:#F8FAFC;color:#101828;line-height:1.6;padding:40px 16px}
        .card{max-width:680px;margin:0 auto;background:#fff;border:1px solid #E5E7EB;border-radius:14px;padding:32px}
        h1{color:#071D49;font-size:1.6rem;margin-bottom:6px}
        .sub{color:#667085;margin-bottom:24px;font-size:.95rem}
        .cfg{background:#F8FAFC;border:1px solid #E5E7EB;border-radius:8px;padding:14px 16px;font-size:.85rem;margin-bottom:24px}
        .cfg code{color:#1B66FF}
        .btn{display:inline-block;background:#FF8A00;color:#fff;border:none;padding:12px 26px;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;text-decoration:none}
        .btn:hover{background:#e67a00}
        .row{display:flex;gap:10px;align-items:flex-start;padding:10px 0;border-bottom:1px solid #F1F5F9}
        .ic{flex-shrink:0;width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:#fff}
        .ic.ok{background:#16a34a}.ic.no{background:#dc2626}
        .detail{color:#667085;font-size:.82rem;word-break:break-word}
        .result{margin-top:24px;padding:16px;border-radius:8px;font-size:.95rem}
        .result.good{background:#dcfce7;color:#166534;border:1px solid #bbf7d0}
        .result.bad{background:#fee2e2;color:#991b1b;border:1px solid #fecaca}
        .warn{margin-top:16px;background:#fef3c7;color:#92400e;border:1px solid #fde68a;padding:12px 16px;border-radius:8px;font-size:.85rem}
    </style>
</head>
<body>
    <div class="card">
        <h1>Bharat SEO — Installer</h1>
        <p class="sub">Creates the database, tables and starter content.</p>

        <div class="cfg">
            Using credentials from <code>config.php</code>:<br>
            Host: <code><?= htmlspecialchars(DB_HOST) ?></code> &nbsp;
            Database: <code><?= htmlspecialchars(DB_NAME) ?></code> &nbsp;
            User: <code><?= htmlspecialchars(DB_USER) ?></code>
            <br><span style="color:#667085">Edit config.php first if these are wrong for your hosting.</span>
        </div>

        <?php if (!$run): ?>
            <form method="POST">
                <button type="submit" class="btn">Run Installation</button>
            </form>
        <?php else: ?>
            <?php foreach ($steps as $s): ?>
                <div class="row">
                    <span class="ic <?= $s['ok'] ? 'ok' : 'no' ?>"><?= $s['ok'] ? '✓' : '✕' ?></span>
                    <div>
                        <div><?= htmlspecialchars($s['label']) ?></div>
                        <?php if ($s['detail']): ?><div class="detail"><?= htmlspecialchars($s['detail']) ?></div><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($ok): ?>
                <div class="result good">
                    <strong>Installation successful!</strong><br>
                    Go to <a href="/admin/">/admin/</a> and log in with <strong>admin / admin123</strong>.
                </div>
                <div class="warn">
                    For security, <strong>delete install.php</strong> from your server now, and set
                    <code>DEBUG_MODE</code> to <code>false</code> in config.php once everything works.
                </div>
            <?php else: ?>
                <div class="result bad">
                    <strong>Installation failed.</strong> Fix the issue marked above (usually database
                    credentials in config.php) and run the installer again.
                </div>
                <form method="POST" style="margin-top:16px"><button type="submit" class="btn">Retry</button></form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
