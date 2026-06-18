<?php
/**
 * Admin - Profile
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $newPassword = $_POST['new_password'] ?? '';
    $fullName = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');

    $stmt = getDB()->prepare("UPDATE admin_users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->execute([$fullName, $email, $_SESSION['admin_id']]);

    if ($newPassword && strlen($newPassword) >= 8) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = getDB()->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$hash, $_SESSION['admin_id']]);
        setFlash('success', 'Profile and password updated.');
    } else {
        setFlash('success', 'Profile updated.');
    }
    redirect('/admin/?page=profile');
}

$stmt = getDB()->prepare("SELECT * FROM admin_users WHERE id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$user = $stmt->fetch();

require __DIR__ . '/admin-header.php';
?>

<h1 class="admin-page-title">Your Profile</h1>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>

<form method="POST" class="admin-form" style="max-width: 500px;">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    <div class="admin-form-group"><label>Username</label><input type="text" value="<?= sanitize($user['username']) ?>" class="admin-input" disabled></div>
    <div class="admin-form-group"><label>Full Name</label><input type="text" name="full_name" value="<?= sanitize($user['full_name']??'') ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Email</label><input type="email" name="email" value="<?= sanitize($user['email']??'') ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>New Password (leave empty to keep current)</label><input type="password" name="new_password" class="admin-input" minlength="8" placeholder="Min 8 characters"></div>
    <p style="font-size: 0.82rem; color: #666; margin-bottom: 1rem;">Last login: <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?></p>
    <button type="submit" class="admin-btn admin-btn-primary">Update Profile</button>
</form>

<?php require __DIR__ . '/admin-footer.php'; ?>
