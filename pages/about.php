<?php
/**
 * About Page - Bharat SEO
 */
$pageSeo = getSeoSettings('about');
$pageSchemas = [
    getLocalBusinessSchema(),
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'About', 'url' => SITE_URL . '/about']
    ])
];
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>About</span>
        </nav>
        <h1>About Bharat SEO</h1>
        <p>We help local businesses across India become visible, trustworthy and easy to contact online.</p>
    </div>
</section>

<!-- Story Section -->
<section class="section fade-up">
    <div class="container">
        <div class="problem-grid">
            <div>
                <span class="section-label">Our Story</span>
                <h2 class="section-heading">Built From a Simple Observation</h2>
                <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 1.25rem;">Most local businesses in India — coaching centres, restaurants, clinics, salons, gyms — deliver excellent services to their customers. But when potential customers search online, these businesses are invisible.</p>
                <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 1.25rem;">Their competitors with better websites and Google visibility get all the enquiries. Not because they are better businesses, but because they are easier to find and contact.</p>
                <p style="color: var(--color-muted); line-height: 1.8;">Bharat SEO was created to solve this problem. We build professional online presence systems that help local businesses get found, get trusted and get contacted by customers who are already looking for their services.</p>
            </div>
            <div>
                <div style="background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 2.5rem; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                    <h3 style="margin-bottom: 1.5rem;">Our Mission</h3>
                    <p style="color: var(--color-muted); line-height: 1.8; margin-bottom: 1.5rem;">To make every local business in India professionally visible online so they can compete fairly and grow through genuine customer enquiries.</p>
                    <h3 style="margin-bottom: 1.5rem;">Our Vision</h3>
                    <p style="color: var(--color-muted); line-height: 1.8;">A business ecosystem where quality local service providers are easy to discover, trust and contact — regardless of their budget or technical knowledge.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Local Businesses Need Digital Growth -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <span class="section-label">The Reality</span>
        <h2 class="section-heading">Why Local Businesses Need Digital Growth Support</h2>
        <p class="section-subtext" style="margin: 0 auto 2.5rem;">The way customers find and choose local businesses has completely changed. Here is what is happening today.</p>
        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            <div class="service-card">
                <h3>Search First</h3>
                <p>Most customers search Google before visiting a local business. If you are not there, you do not exist for them.</p>
            </div>
            <div class="service-card">
                <h3>Trust Through Presence</h3>
                <p>A professional website and Google profile builds instant credibility. Customers compare options online before deciding.</p>
            </div>
            <div class="service-card">
                <h3>Instant Contact</h3>
                <p>Customers expect to call or WhatsApp immediately from search results. If contact is not easy, they move to the next option.</p>
            </div>
            <div class="service-card">
                <h3>Reviews Matter</h3>
                <p>Online reviews directly influence customer decisions. Businesses with more positive reviews get more enquiries.</p>
            </div>
        </div>
    </div>
</section>

<!-- Founder Message -->
<section class="section fade-up">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto; text-align: center;">
            <span class="section-label">Founder's Note</span>
            <h2 class="section-heading" style="margin: 0 auto var(--space-lg);">A Personal Commitment to Local Growth</h2>
            <p style="color: var(--color-muted); line-height: 1.9; margin-bottom: 1.5rem; font-size: 1.05rem;">"I started Bharat SEO because I saw talented local business owners losing customers to competitors who simply had a better online presence. The problem was not their service quality — it was visibility.</p>
            <p style="color: var(--color-muted); line-height: 1.9; margin-bottom: 1.5rem; font-size: 1.05rem;">Every coaching centre deserves students who can find it. Every restaurant deserves customers who discover it on Google. Every clinic deserves patients who trust it online.</p>
            <p style="color: var(--color-muted); line-height: 1.9; font-size: 1.05rem;">Our work is simple: make your business easy to find, easy to trust and easy to contact. That is the entire promise of Bharat SEO."</p>
            <p style="font-weight: var(--fw-semibold); margin-top: 1.5rem; color: var(--color-primary);">— Founder, Bharat SEO</p>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <span class="section-label">What Drives Us</span>
        <h2 class="section-heading">Our Core Values</h2>
        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-top: 2.5rem;">
            <div class="service-card" style="text-align: center;">
                <h3 style="color: var(--color-secondary);">Transparency</h3>
                <p>Clear pricing, honest timelines and straightforward communication. No hidden fees or vague promises.</p>
            </div>
            <div class="service-card" style="text-align: center;">
                <h3 style="color: var(--color-secondary);">Speed</h3>
                <p>Fast delivery without compromising quality. Your business should not wait weeks to go online.</p>
            </div>
            <div class="service-card" style="text-align: center;">
                <h3 style="color: var(--color-secondary);">Simplicity</h3>
                <p>We keep things simple for our clients. No jargon, no confusion. Just clear systems that work.</p>
            </div>
            <div class="service-card" style="text-align: center;">
                <h3 style="color: var(--color-secondary);">Local Growth Focus</h3>
                <p>Everything we do is designed for local businesses. Our strategies are tested for Indian markets.</p>
            </div>
            <div class="service-card" style="text-align: center;">
                <h3 style="color: var(--color-secondary);">Results-Driven</h3>
                <p>We measure success by real enquiries, calls and customers — not just traffic or likes.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section fade-up">
    <div class="container">
        <h2>Ready To Grow Your Business Online?</h2>
        <p>Request a free audit and discover how Bharat SEO can help your business get more enquiries.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Business Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="btn btn-outline-white">WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
