<?php
/**
 * Terms & Conditions - Bharat SEO
 */
$pageSeo = getSeoSettings('terms');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Terms & Conditions', 'url' => SITE_URL . '/terms-conditions']
    ])
];
$agencyName = getSetting('agency_name', 'Bharat SEO');
$email = getSetting('email');

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Terms & Conditions</span>
        </nav>
        <h1>Terms & Conditions</h1>
        <p>Last updated: <?= date('F Y') ?></p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width: 750px;">
        <div class="blog-post-content" style="padding: 0;">
            <h2>Agreement to Terms</h2>
            <p>By accessing and using the <?= sanitize($agencyName) ?> website and services, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not use our website or services.</p>

            <h2>Services</h2>
            <p><?= sanitize($agencyName) ?> provides digital marketing services including website design and development, search engine optimisation, Google Business Profile management, social media marketing, and lead generation systems for local businesses.</p>

            <h2>Service Delivery</h2>
            <ul>
                <li>Delivery timelines are estimates and may vary based on project complexity and client responsiveness.</li>
                <li>We require client cooperation and timely feedback for project completion.</li>
                <li>Final delivery is subject to receipt of all required content and materials from the client.</li>
            </ul>

            <h2>Payment Terms</h2>
            <ul>
                <li>All prices are in Indian Rupees (INR) and exclusive of applicable taxes.</li>
                <li>Payment terms are as discussed and agreed upon before project commencement.</li>
                <li>Monthly services are billed in advance and can be cancelled with 30 days notice.</li>
            </ul>

            <h2>Client Responsibilities</h2>
            <p>Clients are responsible for:</p>
            <ul>
                <li>Providing accurate business information and content</li>
                <li>Timely review and approval of deliverables</li>
                <li>Maintaining domain and hosting accounts</li>
                <li>Ensuring compliance with applicable laws for their business</li>
            </ul>

            <h2>Intellectual Property</h2>
            <p>Upon full payment, clients own the final deliverables created specifically for them. We retain the right to showcase the work in our portfolio unless otherwise agreed.</p>

            <h2>Results Disclaimer</h2>
            <p>While we employ best practices and proven strategies, we cannot guarantee specific ranking positions, traffic numbers or lead volumes. SEO and digital marketing results depend on many factors including competition, market conditions and algorithm changes.</p>

            <h2>Limitation of Liability</h2>
            <p><?= sanitize($agencyName) ?> shall not be liable for any indirect, incidental or consequential damages arising from the use of our services. Our total liability shall not exceed the amount paid for the specific service in question.</p>

            <h2>Termination</h2>
            <p>Either party may terminate ongoing services with 30 days written notice. Work completed up to the termination date will be delivered and billed accordingly.</p>

            <h2>Changes to Terms</h2>
            <p>We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the updated terms.</p>

            <h2>Contact</h2>
            <p>For questions about these terms, contact us at <a href="mailto:<?= sanitize($email) ?>"><?= sanitize($email) ?></a>.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
