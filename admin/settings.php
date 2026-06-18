<?php
/**
 * Admin - Site Settings
 */
$csrfToken = generateCsrfToken();
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    unset($_POST['csrf_token'], $_POST['action']);
    foreach ($_POST as $key => $value) {
        $stmt = getDB()->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
    }
    setFlash('success', 'Settings saved successfully.');
    redirect('/admin/?page=settings');
}

require __DIR__ . '/admin-header.php';
?>

<h1 class="admin-page-title">Site Settings</h1>
<?php if ($flash): ?><div class="admin-alert admin-alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div><?php endif; ?>

<form method="POST" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

    <h2 style="margin-bottom: 1rem;">Brand</h2>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Agency Name</label><input type="text" name="agency_name" value="<?= sanitize(getSetting('agency_name')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Tagline</label><input type="text" name="tagline" value="<?= sanitize(getSetting('tagline')) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Logo URL</label><input type="text" name="logo" value="<?= sanitize(getSetting('logo')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Favicon URL</label><input type="text" name="favicon" value="<?= sanitize(getSetting('favicon')) ?>" class="admin-input"></div>
    </div>

    <h2 style="margin: 2rem 0 1rem;">Colors</h2>
    <div class="admin-form-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="admin-form-group"><label>Primary Color</label><input type="color" name="primary_color" value="<?= getSetting('primary_color', '#071D49') ?>" class="admin-input" style="height:44px"></div>
        <div class="admin-form-group"><label>Secondary Color</label><input type="color" name="secondary_color" value="<?= getSetting('secondary_color', '#FF8A00') ?>" class="admin-input" style="height:44px"></div>
        <div class="admin-form-group"><label>Accent Color</label><input type="color" name="accent_color" value="<?= getSetting('accent_color', '#1B66FF') ?>" class="admin-input" style="height:44px"></div>
    </div>

    <h2 style="margin: 2rem 0 1rem;">Contact</h2>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Phone</label><input type="text" name="phone" value="<?= sanitize(getSetting('phone')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>WhatsApp</label><input type="text" name="whatsapp" value="<?= sanitize(getSetting('whatsapp')) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Email</label><input type="email" name="email" value="<?= sanitize(getSetting('email')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Address</label><input type="text" name="address" value="<?= sanitize(getSetting('address')) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-group"><label>Business Hours</label><input type="text" name="business_hours" value="<?= sanitize(getSetting('business_hours')) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Google Map Embed Code</label><textarea name="google_map_embed" class="admin-input" rows="3"><?= htmlspecialchars(getSetting('google_map_embed')) ?></textarea></div>

    <h2 style="margin: 2rem 0 1rem;">Social Media</h2>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Instagram URL</label><input type="url" name="instagram_url" value="<?= sanitize(getSetting('instagram_url')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Facebook URL</label><input type="url" name="facebook_url" value="<?= sanitize(getSetting('facebook_url')) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>LinkedIn URL</label><input type="url" name="linkedin_url" value="<?= sanitize(getSetting('linkedin_url')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>YouTube URL</label><input type="url" name="youtube_url" value="<?= sanitize(getSetting('youtube_url')) ?>" class="admin-input"></div>
    </div>

    <h2 style="margin: 2rem 0 1rem;">Hero Section</h2>
    <div class="admin-form-group"><label>Hero Heading</label><input type="text" name="hero_heading" value="<?= sanitize(getSetting('hero_heading')) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Hero Subheading</label><textarea name="hero_subheading" class="admin-input" rows="3"><?= sanitize(getSetting('hero_subheading')) ?></textarea></div>
    <div class="admin-form-group"><label>Hero Image URL</label><input type="text" name="hero_image" value="<?= sanitize(getSetting('hero_image')) ?>" class="admin-input"></div>

    <h2 style="margin: 2rem 0 1rem;">SEO & Tracking</h2>
    <div class="admin-form-group"><label>Default Meta Title</label><input type="text" name="default_meta_title" value="<?= sanitize(getSetting('default_meta_title')) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Default Meta Description</label><textarea name="default_meta_description" class="admin-input" rows="2"><?= sanitize(getSetting('default_meta_description')) ?></textarea></div>
    <div class="admin-form-grid">
        <div class="admin-form-group"><label>Default Meta Keywords</label><input type="text" name="default_meta_keywords" value="<?= sanitize(getSetting('default_meta_keywords')) ?>" class="admin-input"></div>
        <div class="admin-form-group"><label>Canonical Site URL</label><input type="url" name="canonical_site_url" value="<?= sanitize(getSetting('canonical_site_url')) ?>" class="admin-input"></div>
    </div>
    <div class="admin-form-group"><label>Google Analytics Code</label><textarea name="google_analytics" class="admin-input" rows="3"><?= htmlspecialchars(getSetting('google_analytics')) ?></textarea></div>
    <div class="admin-form-group"><label>Search Console Verification</label><input type="text" name="search_console_verification" value="<?= sanitize(getSetting('search_console_verification')) ?>" class="admin-input"></div>
    <div class="admin-form-group"><label>Meta Pixel Code</label><textarea name="meta_pixel" class="admin-input" rows="3"><?= htmlspecialchars(getSetting('meta_pixel')) ?></textarea></div>

    <h2 style="margin: 2rem 0 1rem;">Footer</h2>
    <div class="admin-form-group"><label>Footer Text</label><input type="text" name="footer_text" value="<?= sanitize(getSetting('footer_text')) ?>" class="admin-input"></div>

    <div class="admin-form-actions"><button type="submit" class="admin-btn admin-btn-primary">Save All Settings</button></div>
</form>

<?php require __DIR__ . '/admin-footer.php'; ?>
