<?php
/**
 * Admin - Media Manager
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $pa = $_POST['action'] ?? '';

    if ($pa === 'upload' && isset($_FILES['file'])) {
        $file = $_FILES['file'];
        if ($file['error'] === UPLOAD_ERR_OK && $file['size'] <= MAX_UPLOAD_SIZE) {
            $allowedTypes = ['image/jpeg','image/png','image/gif','image/webp','image/svg+xml'];
            if (in_array($file['type'], $allowedTypes)) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = date('Y-m-d') . '-' . createSlug(pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
                $uploadPath = UPLOAD_DIR . $fileName;

                if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $stmt = getDB()->prepare("INSERT INTO media (file_name, file_path, file_type, file_size, title, alt_text) VALUES (?,?,?,?,?,?)");
                    $stmt->execute([$fileName, UPLOAD_URL . $fileName, $file['type'], $file['size'], sanitize($_POST['title']??$fileName), sanitize($_POST['alt_text']??'')]);
                    setFlash('success', 'File uploaded successfully.');
                } else {
                    setFlash('error', 'Failed to move uploaded file.');
                }
            } else {
                setFlash('error', 'File type not allowed. Use JPG, PNG, GIF, WebP or SVG.');
            }
        } else {
            setFlash('error', 'File too large or upload error.');
        }
        redirect('/admin/?page=media');
    }

    if ($pa === 'delete') {
        $id = intval($_POST['id']??0);
        $stmt = getDB()->prepare("SELECT file_path FROM media WHERE id = ?");
        $stmt->execute([$id]);
        $media = $stmt->fetch();
        if ($media) {
            $fullPath = __DIR__ . '/..' . $media['file_path'];
            if (file_exists($fullPath)) unlink($fullPath);
            getDB()->prepare("DELETE FROM media WHERE id = ?")->execute([$id]);
            setFlash('success', 'File deleted.');
        }
        redirect('/admin/?page=media');
    }

    if ($pa === 'update_meta') {
        $id = intval($_POST['id']??0);
        getDB()->prepare("UPDATE media SET title = ?, alt_text = ? WHERE id = ?")->execute([sanitize($_POST['title']??''), sanitize($_POST['alt_text']??''), $id]);
        setFlash('success', 'Media updated.');
        redirect('/admin/?page=media');
    }
}

$mediaFiles = getDB()->query("SELECT * FROM media ORDER BY uploaded_at DESC")->fetchAll();

require __DIR__ . '/admin-header.php';
?>

<h1 class="admin-page-title">Media Manager</h1>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>

<!-- Upload Form -->
<div style="background: var(--admin-bg-alt); border: 1px solid var(--admin-border); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem;">Upload Image</h3>
    <form method="POST" enctype="multipart/form-data" class="admin-form" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
        <input type="hidden" name="action" value="upload">
        <div class="admin-form-group" style="margin:0; flex:1; min-width:200px;"><label>File</label><input type="file" name="file" accept="image/*,.webp" required class="admin-input"></div>
        <div class="admin-form-group" style="margin:0; flex:1; min-width:150px;"><label>Title</label><input type="text" name="title" class="admin-input" placeholder="Image title"></div>
        <div class="admin-form-group" style="margin:0; flex:1; min-width:150px;"><label>Alt Text</label><input type="text" name="alt_text" class="admin-input" placeholder="Alt text for SEO"></div>
        <button type="submit" class="admin-btn admin-btn-primary">Upload</button>
    </form>
</div>

<!-- Media Library -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
    <?php foreach ($mediaFiles as $m): ?>
    <div style="border: 1px solid var(--admin-border); border-radius: 8px; overflow: hidden; background: white;">
        <div style="height: 140px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <img src="<?= sanitize($m['file_path']) ?>" alt="<?= sanitize($m['alt_text']??$m['title']) ?>" style="max-width: 100%; max-height: 140px; object-fit: cover;">
        </div>
        <div style="padding: 0.75rem;">
            <p style="font-size: 0.78rem; color: #666; word-break: break-all; margin-bottom: 0.5rem;"><?= sanitize($m['file_name']) ?></p>
            <input type="text" value="<?= sanitize($m['file_path']) ?>" readonly style="width:100%; font-size: 0.72rem; padding: 0.3rem; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 0.5rem;" onclick="this.select()">
            <form method="POST" onsubmit="return confirm('Delete this file?')">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                <button class="admin-btn admin-btn-danger admin-btn-sm" style="width:100%">Delete</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (!$mediaFiles): ?>
    <p class="admin-empty" style="grid-column: 1 / -1;">No media files uploaded yet.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/admin-footer.php'; ?>
