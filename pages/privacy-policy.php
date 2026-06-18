<?php
/**
 * Privacy Policy - Bharat SEO
 */
$pageSeo = getSeoSettings('privacy');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Privacy Policy', 'url' => SITE_URL . '/privacy-policy']
    ])
];
$agencyName = getSetting('agency_name', 'Bharat SEO');
$email = getSetting('email');

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Privacy Policy</span>
        </nav>
        <h1>Privacy Policy</h1>
        <p>Last updated: <?= date('F Y') ?></p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width: 750px;">
        <div class="blog-post-content" style="padding: 0;">
            <h2>Introduction</h2>
            <p><?= sanitize($agencyName) ?> ("we", "us", or "our") respects your privacy and is committed to protecting your personal data. This privacy policy explains how we collect, use and protect information when you visit our website or use our services.</p>

            <h2>Information We Collect</h2>
            <p>We collect information that you voluntarily provide when you:</p>
            <ul>
                <li>Fill out contact forms or enquiry forms</li>
                <li>Request a free business audit</li>
                <li>Subscribe to our blog or newsletter</li>
                <li>Contact us via phone, email or WhatsApp</li>
            </ul>
            <p>This information may include your name, business name, phone number, email address, city, website URL and business type.</p>

            <h2>How We Use Your Information</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Respond to your enquiries and requests</li>
                <li>Provide business audit reports</li>
                <li>Communicate about our services</li>
                <li>Send relevant updates if you have opted in</li>
                <li>Improve our website and services</li>
            </ul>

            <h2>Data Protection</h2>
            <p>We implement appropriate security measures to protect your personal information. Your data is stored securely and is only accessible to authorised team members who need it to provide our services.</p>

            <h2>Third-Party Services</h2>
            <p>Our website may use third-party services such as Google Analytics, Google Search Console and social media platforms. These services have their own privacy policies and we encourage you to review them.</p>

            <h2>Cookies</h2>
            <p>Our website may use cookies to improve user experience and analyse website traffic. You can control cookie settings through your browser preferences.</p>

            <h2>Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access the personal data we hold about you</li>
                <li>Request correction of inaccurate data</li>
                <li>Request deletion of your data</li>
                <li>Opt out of marketing communications</li>
            </ul>

            <h2>Data Retention</h2>
            <p>We retain your personal information only as long as necessary to provide our services and fulfil the purposes outlined in this policy.</p>

            <h2>Changes to This Policy</h2>
            <p>We may update this privacy policy from time to time. The updated version will be indicated by the "Last updated" date at the top of this page.</p>

            <h2>Contact Us</h2>
            <p>If you have questions about this privacy policy or our data practices, please contact us at <a href="mailto:<?= sanitize($email) ?>"><?= sanitize($email) ?></a>.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
