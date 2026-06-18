<?php
/**
 * Admin Login
 */
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrf)) {
        $error = 'Security verification failed.';
    } else {
        $stmt = getDB()->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['must_change_password'] = (bool)$user['must_change_password'];

            // Update last login
            $updateStmt = getDB()->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
            $updateStmt->execute([$user['id']]);

            redirect('/admin/?page=dashboard');
        } else {
            $error = 'Invalid username or password.';
        }
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
    <title>Admin Login - Bharat SEO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/admin.css">
</head>
<body class="admin-login-body">
    <div class="admin-login-card">
        <div class="admin-login-header">
            <h1>Bharat SEO</h1>
            <p>Admin Panel</p>
        </div>
        <?php if ($error): ?>
        <div class="admin-alert admin-alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <div class="admin-form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="admin-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="width: 100%;">Login</button>
        </form>
    </div>
</body>
</html>
