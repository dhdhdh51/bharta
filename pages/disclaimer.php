<?php
/**
 * Disclaimer - Bharat SEO
 */
$pageSeo = getSeoSettings('disclaimer');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Disclaimer', 'url' => SITE_URL . '/disclaimer']
    ])
];
$agencyName = getSetting('agency_name', 'Bharat SEO');

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Disclaimer</span>
        </nav>
        <h1>Disclaimer</h1>
        <p>Last updated: <?= date('F Y') ?></p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width: 750px;">
        <div class="blog-post-content" style="padding: 0;">
            <h2>General Disclaimer</h2>
            <p>The information provided on the <?= sanitize($agencyName) ?> website is for general informational purposes only. While we strive to keep the information accurate and up-to-date, we make no representations or warranties of any kind about the completeness, accuracy, reliability or availability of the website or the information contained on it.</p>

            <h2>Results Disclaimer</h2>
            <p>Any case studies, testimonials or results mentioned on this website are individual experiences and do not guarantee that you will achieve similar results. Digital marketing results depend on numerous factors including industry, competition, location, budget, market conditions and search engine algorithm updates.</p>

            <h2>No Guaranteed Rankings</h2>
            <p>We do not guarantee specific search engine rankings, map positions or traffic numbers. SEO is a long-term strategy and results vary based on many factors outside our direct control.</p>

            <h2>Third-Party Links</h2>
            <p>Our website may contain links to third-party websites. We have no control over the content, privacy policies or practices of these sites and assume no responsibility for them.</p>

            <h2>Professional Advice</h2>
            <p>The content on this website does not constitute professional business, legal or financial advice. Consult appropriate professionals for advice specific to your situation.</p>

            <h2>Pricing</h2>
            <p>All prices mentioned on this website are subject to change without prior notice. Final pricing is confirmed during consultation based on specific project requirements.</p>

            <h2>Availability</h2>
            <p>Services described on this website are subject to availability. We reserve the right to accept or decline projects based on our capacity and alignment with client needs.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
