<?php
/**
 * Thank You Page - Bharat SEO
 */
$pageSeo = getSeoSettings('thank_you');
$seoOverrides = ['robots_meta' => 'noindex, nofollow'];
$pageSchemas = [];

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section style="padding: calc(var(--header-height) + 4rem) 0 4rem; text-align: center; min-height: 60vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 600px;">
        <div style="width: 72px; height: 72px; background: rgba(37, 211, 102, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
        </div>
        <h1>Thank You! Your Request Has Been Received.</h1>
        <p style="color: var(--color-muted); font-size: 1.1rem; line-height: 1.8; margin-top: 1rem; margin-bottom: 2rem;">Our team will review your details and contact you shortly. You can also message us directly on WhatsApp for a faster response.</p>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
            <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%2C%20I%20just%20submitted%20a%20request%20on%20your%20website." target="_blank" class="btn btn-primary btn-lg">WhatsApp Us Now</a>
            <a href="/" class="btn btn-secondary btn-lg">Back To Home</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
