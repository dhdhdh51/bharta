<?php
/**
 * Contact Page - Bharat SEO
 */
$pageSeo = getSeoSettings('contact');
$pageSchemas = [
    getLocalBusinessSchema(),
    getBreadcrumbSchema([
        ['name' => 'Home', 'url' => SITE_URL],
        ['name' => 'Contact', 'url' => SITE_URL . '/contact']
    ])
];

$phone = getSetting('phone');
$whatsapp = getSetting('whatsapp');
$whatsappClean = preg_replace('/[^0-9]/', '', $whatsapp);
$email = getSetting('email');
$address = getSetting('address');
$businessHours = getSetting('business_hours');
$mapEmbed = getSetting('google_map_embed');
$flash = getFlash();
$csrfToken = generateCsrfToken();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-list" aria-label="Breadcrumb">
            <a href="/">Home</a><span class="breadcrumb-sep">/</span><span>Contact</span>
        </nav>
        <h1>Contact Bharat SEO</h1>
        <p>Ready to grow your business online? Get in touch with us through any of the channels below.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Info -->
            <div>
                <div class="contact-info-card">
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div>
                        <div>
                            <h4>Phone</h4>
                            <p><a href="tel:<?= sanitize($phone) ?>"><?= sanitize($phone) ?></a></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
                        <div>
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/<?= $whatsappClean ?>" target="_blank"><?= sanitize($whatsapp) ?></a></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <div>
                            <h4>Email</h4>
                            <p><a href="mailto:<?= sanitize($email) ?>"><?= sanitize($email) ?></a></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                        <div>
                            <h4>Location</h4>
                            <p><?= sanitize($address) ?></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg></div>
                        <div>
                            <h4>Business Hours</h4>
                            <p><?= sanitize($businessHours) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Quick CTAs -->
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="https://wa.me/<?= $whatsappClean ?>?text=Hi%20Bharat%20SEO%2C%20I%20want%20to%20discuss%20a%20project." target="_blank" class="btn btn-primary" style="flex: 1; min-width: 140px;">WhatsApp Now</a>
                    <a href="tel:<?= sanitize($phone) ?>" class="btn btn-secondary" style="flex: 1; min-width: 140px;">Call Now</a>
                </div>

                <!-- Map -->
                <?php if ($mapEmbed): ?>
                <div style="margin-top: 1.5rem; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--color-border);">
                    <?= $mapEmbed ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 style="margin-bottom: 0.5rem;">Send Us a Message</h2>
                <p style="color: var(--color-muted); margin-bottom: 1.5rem; font-size: 0.92rem;">Fill out the form below and we will get back to you within 24 hours.</p>

                <?php if ($flash): ?>
                <div class="form-error" style="<?= $flash['type'] === 'success' ? 'background: rgba(37,211,102,0.08); border-color: rgba(37,211,102,0.2); color: #059669;' : '' ?>">
                    <?= sanitize($flash['message']) ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="/contact" data-validate>
                    <input type="hidden" name="form_type" value="contact">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                    <input type="hidden" name="source_page" value="contact">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" id="business_name" name="business_name" placeholder="Your business name">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="+91-XXXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="business_type">Business Type</label>
                            <select id="business_type" name="business_type">
                                <option value="">Select your business type</option>
                                <option value="Coaching Centre">Coaching Centre</option>
                                <option value="Restaurant">Restaurant / Cafe</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Gym">Gym / Fitness</option>
                                <option value="Clinic">Clinic / Healthcare</option>
                                <option value="Salon">Salon / Beauty</option>
                                <option value="Local Shop">Local Shop</option>
                                <option value="Professional Service">Professional Service</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="Your city">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Tell us about your requirements..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Send Message</button>
                    <p class="form-note">We typically respond within 2-4 hours during business hours.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
