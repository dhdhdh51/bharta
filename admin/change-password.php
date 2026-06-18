<?php
/**
 * Admin - Change Password
 */
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrf)) {
        $error = 'Security verification failed.';
    } elseif (strlen($newPassword) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = getDB()->prepare("UPDATE admin_users SET password_hash = ?, must_change_password = 0 WHERE id = ?");
        $stmt->execute([$hash, $_SESSION['admin_id']]);
        $_SESSION['must_change_password'] = false;
        redirect('/admin/?page=dashboard');
    }
}

$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Change Password - Bharat SEO Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/admin.css">
</head>
<body class="admin-login-body">
    <div class="admin-login-card">
        <div class="admin-login-header">
            <h1>Change Password</h1>
            <p>You must change your password before continuing.</p>
        </div>
        <?php if ($error): ?>
        <div class="admin-alert admin-alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <div class="admin-form-group">
                <label for="new_password">New Password (min 8 characters)</label>
                <input type="password" id="new_password" name="new_password" required minlength="8">
            </div>
            <div class="admin-form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="width: 100%;">Update Password</button>
        </form>
    </div>
</body>
</html>
