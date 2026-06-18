<?php
/**
 * Home Page - Bharat SEO
 */
$pageSeo = getSeoSettings('home');
$pageSchemas = [getLocalBusinessSchema()];

// Fetch services
$services = getDB()->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 8")->fetchAll();
// Fetch industries
$industries = getDB()->query("SELECT * FROM industries WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 8")->fetchAll();
// Fetch packages
$packages = getDB()->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
// Fetch testimonials
$testimonials = getDB()->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 3")->fetchAll();
// Fetch case studies
$caseStudies = getDB()->query("SELECT * FROM case_studies WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();

$heroHeading = getSetting('hero_heading', 'Get More Calls, WhatsApp Enquiries and Customers for Your Business');
$heroSubheading = getSetting('hero_subheading');
$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));

require_once __DIR__ . '/../includes/header.php';
?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <span class="hero-eyebrow">Digital Growth Partner for Local Businesses</span>
                <h1><?= sanitize($heroHeading) ?></h1>
                <p class="hero-subtext"><?= sanitize($heroSubheading) ?></p>
                <div class="hero-ctas">
                    <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Business Audit</a>
                    <a href="/services" class="btn btn-outline-white">View Our Services</a>
                </div>
                <p class="hero-trust">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Trusted by growing local businesses across India
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF8A00" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div>
                        <span class="hero-stat-text">Website + SEO Setup</span>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF8A00" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                        <span class="hero-stat-text">Google Map Visibility</span>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF8A00" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
                        <span class="hero-stat-text">WhatsApp Lead System</span>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF8A00" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
                        <span class="hero-stat-text">Local Business Growth</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-visual-card">
                    <div class="hero-visual-mockup">
                        <span class="hero-visual-mockup-text">Premium Website Dashboard Preview</span>
                    </div>
                    <div class="hero-floating-cards">
                        <div class="hero-float-card"><span>📍 Google Maps #1</span></div>
                        <div class="hero-float-card"><span>💬 New WhatsApp Lead</span></div>
                        <div class="hero-float-card"><span>📞 +3 Calls Today</span></div>
                        <div class="hero-float-card"><span>⭐ 5-Star Review</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- TRUST BAR -->
<section class="trust-bar">
    <div class="container">
        <div class="trust-items">
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg></div>
                Mobile-First Websites
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                Google Map SEO
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
                WhatsApp Lead Setup
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg></div>
                Local Business Focus
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                Transparent Pricing
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3"/><path d="M15 3h6v6"/><path d="M21 3l-7 7"/></svg></div>
                Fast Support
            </div>
        </div>
    </div>
</section>

<!-- PROBLEM TO SOLUTION -->
<section class="section fade-up">
    <div class="container">
        <span class="section-label">The Problem</span>
        <h2 class="section-heading">Your Business Should Be Easy To Find, Easy To Trust and Easy To Contact</h2>
        <div class="problem-grid">
            <div class="problem-list">
                <div class="problem-item">
                    <div class="problem-item-icon">✕</div>
                    <p>Customers cannot find your business on Google when they search for services you offer in your area.</p>
                </div>
                <div class="problem-item">
                    <div class="problem-item-icon">✕</div>
                    <p>Your website does not convert visitors into enquiries because it is not designed for lead generation.</p>
                </div>
                <div class="problem-item">
                    <div class="problem-item-icon">✕</div>
                    <p>Your Google profile and WhatsApp system are not working together to capture every potential customer.</p>
                </div>
            </div>
            <div>
                <h3 style="margin-bottom: 1.25rem; font-size: 1.1rem;">Bharat SEO Solves This</h3>
                <div class="solution-list">
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>High-converting professional website</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Google Map optimisation for local visibility</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>WhatsApp enquiry system for instant leads</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>SEO content that drives organic traffic</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Monthly growth support and reporting</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- SERVICES SECTION -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <span class="section-label">Our Services</span>
        <h2 class="section-heading">Everything Your Local Business Needs To Grow Online</h2>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card">
                <div class="service-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <h3><?= sanitize($service['title']) ?></h3>
                <p><?= sanitize(truncateText($service['short_description'], 100)) ?></p>
                <a href="/services/<?= sanitize($service['slug']) ?>" class="service-card-link">Learn More →</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- INDUSTRIES SECTION -->
<section class="section fade-up">
    <div class="container section-center">
        <span class="section-label">Industries We Serve</span>
        <h2 class="section-heading">Built For Businesses That Need More Local Customers</h2>
        <div class="industry-grid">
            <?php foreach ($industries as $industry): ?>
            <a href="/industries/<?= sanitize($industry['slug']) ?>" class="industry-card">
                <div class="industry-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-secondary)" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                </div>
                <h3><?= sanitize(str_replace('Digital Marketing for ', '', $industry['title'])) ?></h3>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <span class="section-label">Our Process</span>
        <h2 class="section-heading">A Simple Growth System For Your Business</h2>
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-number">1</div>
                <h3>Free Business Audit</h3>
                <p>We check your website, Google profile, local SEO and WhatsApp enquiry setup.</p>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <h3>Growth Plan</h3>
                <p>We prepare a clear action plan based on your business category and city.</p>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <h3>Design & Optimisation</h3>
                <p>We build your website, optimise your profile and set up lead channels.</p>
            </div>
            <div class="step-item">
                <div class="step-number">4</div>
                <h3>Lead Activation</h3>
                <p>Your customers can directly call, WhatsApp or submit enquiries.</p>
            </div>
            <div class="step-item">
                <div class="step-number">5</div>
                <h3>Monthly Growth</h3>
                <p>We improve visibility, content, reviews and local search performance.</p>
            </div>
        </div>
    </div>
</section>


<!-- CASE STUDIES -->
<?php if ($caseStudies): ?>
<section class="section fade-up">
    <div class="container section-center">
        <span class="section-label">Results</span>
        <h2 class="section-heading">Built To Turn Online Searches Into Real Enquiries</h2>
        <div class="case-grid">
            <?php foreach ($caseStudies as $case): ?>
            <a href="/case-studies/<?= sanitize($case['slug']) ?>" class="case-card">
                <div class="case-card-image">
                    <?php if ($case['featured_image']): ?>
                    <img src="<?= sanitize($case['featured_image']) ?>" alt="<?= sanitize($case['title']) ?>" loading="lazy">
                    <?php else: ?>
                    Case Study Preview
                    <?php endif; ?>
                </div>
                <div class="case-card-body">
                    <span class="case-card-tag"><?= sanitize($case['industry']) ?></span>
                    <h3><?= sanitize($case['title']) ?></h3>
                    <p><?= sanitize(truncateText($case['result_summary'], 120)) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PACKAGES -->
<section class="section section-gray fade-up" id="packages">
    <div class="container section-center">
        <span class="section-label">Pricing</span>
        <h2 class="section-heading">Simple Plans For Local Business Growth</h2>
        <div class="packages-grid">
            <?php foreach ($packages as $pkg): ?>
            <div class="package-card <?= $pkg['is_highlighted'] ? 'highlighted' : '' ?>">
                <?php if ($pkg['is_highlighted']): ?>
                <span class="package-badge">Most Popular</span>
                <?php endif; ?>
                <h3 class="package-name"><?= sanitize($pkg['package_name']) ?></h3>
                <div class="package-price"><?= formatPrice($pkg['price']) ?></div>
                <?php if ($pkg['monthly_price']): ?>
                <div class="package-monthly">+ <?= formatPrice($pkg['monthly_price']) ?>/month support</div>
                <?php else: ?>
                <div class="package-monthly">One-time payment</div>
                <?php endif; ?>
                <ul class="package-features">
                    <?php foreach (jsonDecode($pkg['features']) as $feature): ?>
                    <li><?= sanitize($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%2C%20I%20am%20interested%20in%20the%20<?= urlencode($pkg['package_name']) ?>%20package." class="btn <?= $pkg['is_highlighted'] ? 'btn-primary' : 'btn-secondary' ?>"><?= sanitize($pkg['cta_text']) ?></a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FREE AUDIT CTA -->
<section class="cta-section fade-up">
    <div class="container">
        <h2>Know What Is Stopping Your Business From Getting More Enquiries</h2>
        <p>Request a free business audit and get practical improvement points for your website, Google profile, WhatsApp setup and local SEO.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get My Free Audit</a>
        </div>
    </div>
</section>


<!-- TESTIMONIALS -->
<?php if ($testimonials): ?>
<section class="section fade-up">
    <div class="container section-center">
        <span class="section-label">Testimonials</span>
        <h2 class="section-heading">What Our Clients Say</h2>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-card">
                <div class="testimonial-stars"><?= str_repeat('★', $testimonial['rating']) ?></div>
                <p class="testimonial-text">"<?= sanitize($testimonial['review']) ?>"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"><?= strtoupper(substr($testimonial['client_name'], 0, 1)) ?></div>
                    <div class="testimonial-info">
                        <h4><?= sanitize($testimonial['client_name']) ?></h4>
                        <p><?= sanitize($testimonial['business_name']) ?>, <?= sanitize($testimonial['city']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ -->
<section class="section section-gray fade-up">
    <div class="container section-center">
        <span class="section-label">FAQ</span>
        <h2 class="section-heading">Frequently Asked Questions</h2>
        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question">How much does a business website cost?</button>
                <div class="faq-answer"><p>Our website packages start at ₹2,999 for a single-page mobile-friendly website. Multi-page professional websites start at ₹6,999. The final cost depends on the number of pages, features and design complexity you need.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do you work with businesses outside my city?</button>
                <div class="faq-answer"><p>Yes, we work with local businesses across India. Our services are designed to help you rank in your specific city and service area regardless of where we are located.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Can you help my business show on Google Maps?</button>
                <div class="faq-answer"><p>Absolutely. Google Business Profile optimisation and local SEO are our core services. We help your business appear in the Google Map pack for relevant searches in your area.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do you provide WhatsApp enquiry setup?</button>
                <div class="faq-answer"><p>Yes, we set up click-to-WhatsApp buttons on your website, automated greeting messages, quick reply templates and WhatsApp links for your social media profiles.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">How long does website delivery take?</button>
                <div class="faq-answer"><p>Single-page websites are delivered in 2-3 working days. Multi-page websites take 5-7 working days. Premium websites may take 7-10 working days depending on requirements.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Can I update my website later?</button>
                <div class="faq-answer"><p>Yes, all our websites are easy to update. We can train you on basic updates or manage changes for you as part of our monthly support plans.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do you provide monthly SEO services?</button>
                <div class="faq-answer"><p>Yes, our Growth and Pro packages include monthly SEO support including content updates, Google profile management, ranking reports and continuous optimisation.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do you work with coaching centres and restaurants?</button>
                <div class="faq-answer"><p>Yes, coaching centres and restaurants are among our primary focus industries. We have specific strategies and templates designed for these business types.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Is domain and hosting included?</button>
                <div class="faq-answer"><p>Domain and hosting are not included in the base price but we provide complete guidance on selecting and setting up reliable Indian hosting providers at affordable rates.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Can I get a free audit before starting?</button>
                <div class="faq-answer"><p>Yes, we offer a completely free business audit where we check your current website, Google profile, local SEO status and WhatsApp setup. Request yours from the Free Audit page.</p></div>
            </div>
        </div>
    </div>
</section>

<!-- FINAL CTA -->
<section class="cta-section fade-up">
    <div class="container">
        <h2>Your Next Customer Is Already Searching Online</h2>
        <p>Let Bharat SEO help your business appear professional, visible and easy to contact.</p>
        <div class="cta-buttons">
            <a href="/free-audit" class="btn btn-primary btn-lg">Get Free Audit</a>
            <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%20Bharat%20SEO%2C%20I%20want%20to%20know%20about%20your%20services." target="_blank" class="btn btn-white">WhatsApp Bharat SEO</a>
            <a href="tel:<?= sanitize(getSetting('phone')) ?>" class="btn btn-outline-white">Call Now</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
