<?php
/**
 * Free Business Audit Page - Bharat SEO
 */
$pageSeo = getSeoSettings('free_audit');
$pageSchemas = [
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Free Business Audit', 'url' => SITE_URL . '/free-audit']
    ])
];

$whatsappClean = preg_replace('/[^0-9]/', '', getSetting('whatsapp'));
$flash = getFlash();
$csrfToken = generateCsrfToken();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Free Business Audit</span>
        </nav>
        <h1>Free Business Audit</h1>
        <p>Get a detailed analysis of your website, Google Business Profile, local SEO and WhatsApp enquiry setup — completely free.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- What You Get -->
            <div>
                <h2 style="margin-bottom: 1.5rem;">What We Analyse</h2>
                <div class="solution-list">
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Website performance and mobile friendliness</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Google Business Profile completeness and optimisation</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Local SEO visibility and keyword opportunities</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>WhatsApp and lead capture setup</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Social media presence and content</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Competitor comparison in your area</p>
                    </div>
                    <div class="solution-item">
                        <div class="solution-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20,6 9,17 4,12"/></svg></div>
                        <p>Actionable improvement recommendations</p>
                    </div>
                </div>

                <div style="margin-top: 2rem; background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.75rem; font-size: 1rem;">How It Works</h3>
                    <ol style="color: var(--color-muted); font-size: 0.9rem; line-height: 1.8; padding-left: 1.25rem; list-style: decimal;">
                        <li>Fill the form with your business details</li>
                        <li>Our team reviews your online presence</li>
                        <li>We prepare a detailed audit report</li>
                        <li>We share the report via WhatsApp or email</li>
                        <li>Optional: Discuss growth plan with our team</li>
                    </ol>
                    <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--color-muted); font-style: italic;">No obligation. No spam. Just practical insights for your business.</p>
                </div>
            </div>

            <!-- Audit Form -->
            <div>
                <h2 style="margin-bottom: 0.5rem;">Request Your Free Audit</h2>
                <p style="color: var(--color-muted); margin-bottom: 1.5rem; font-size: 0.92rem;">Fill in your details and we will audit your business within 48 hours.</p>

                <?php if ($flash): ?>
                <div class="form-error"><?= sanitize($flash['message']) ?></div>
                <?php endif; ?>

                <form method="POST" action="/free-audit" data-validate>
                    <input type="hidden" name="form_type" value="audit">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Your full name">
                        </div>
                        <div class="form-group">
                            <label for="business_name">Business Name *</label>
                            <input type="text" id="business_name" name="business_name" required placeholder="Your business name">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="+91-XXXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label for="whatsapp_number">WhatsApp Number</label>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" placeholder="Same as phone or different">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com">
                        </div>
                        <div class="form-group">
                            <label for="business_type">Business Type *</label>
                            <select id="business_type" name="business_type" required>
                                <option value="">Select business type</option>
                                <option value="Coaching Centre">Coaching Centre</option>
                                <option value="Restaurant">Restaurant / Cafe</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Gym">Gym / Fitness</option>
                                <option value="Clinic">Clinic / Healthcare</option>
                                <option value="Salon">Salon / Beauty</option>
                                <option value="Local Shop">Local Shop</option>
                                <option value="Hotel">Hotel / Hospitality</option>
                                <option value="Bakery">Bakery</option>
                                <option value="Institute">Institute</option>
                                <option value="Professional Service">Professional Service</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required placeholder="Your business city">
                        </div>
                        <div class="form-group">
                            <label for="main_service">Main Service/Product</label>
                            <input type="text" id="main_service" name="main_service" placeholder="What you mainly offer">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="website_url">Website URL (if any)</label>
                        <input type="url" id="website_url" name="website_url" placeholder="https://yourwebsite.com">
                    </div>

                    <div class="form-group">
                        <label for="google_profile_link">Google Business Profile Link</label>
                        <input type="url" id="google_profile_link" name="google_profile_link" placeholder="https://g.page/your-business">
                    </div>

                    <div class="form-group">
                        <label for="instagram_link">Instagram Link</label>
                        <input type="url" id="instagram_link" name="instagram_link" placeholder="https://instagram.com/yourbusiness">
                    </div>

                    <div class="form-group">
                        <label for="message">Anything else we should know?</label>
                        <textarea id="message" name="message" rows="3" placeholder="Any specific concerns or goals..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Request Free Audit</button>
                    <p class="form-note">Your information is secure. We will never share it with anyone.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
