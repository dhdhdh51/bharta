-- Bharat SEO - Complete Database Schema
-- Version: 1.0
-- PHP 8+ / MySQL 5.7+

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `bharat_seo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bharat_seo`;

-- ============================================
-- TABLE: admin_users
-- ============================================
CREATE TABLE `admin_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(150) DEFAULT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `must_change_password` TINYINT(1) DEFAULT 1,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: site_settings
-- ============================================
CREATE TABLE `site_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: seo_settings
-- ============================================
CREATE TABLE `seo_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_key` VARCHAR(100) NOT NULL UNIQUE,
  `page_name` VARCHAR(200) NOT NULL,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `meta_keywords` VARCHAR(500) DEFAULT NULL,
  `slug` VARCHAR(200) DEFAULT NULL,
  `canonical_url` VARCHAR(500) DEFAULT NULL,
  `robots_meta` VARCHAR(100) DEFAULT 'index, follow',
  `og_title` VARCHAR(255) DEFAULT NULL,
  `og_description` TEXT DEFAULT NULL,
  `og_image` VARCHAR(500) DEFAULT NULL,
  `twitter_title` VARCHAR(255) DEFAULT NULL,
  `twitter_description` TEXT DEFAULT NULL,
  `twitter_image` VARCHAR(500) DEFAULT NULL,
  `focus_keyword` VARCHAR(200) DEFAULT NULL,
  `schema_json` TEXT DEFAULT NULL,
  `custom_header_scripts` TEXT DEFAULT NULL,
  `custom_footer_scripts` TEXT DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: services
-- ============================================
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `icon` VARCHAR(500) DEFAULT NULL,
  `featured_image` VARCHAR(500) DEFAULT NULL,
  `short_description` TEXT DEFAULT NULL,
  `full_description` LONGTEXT DEFAULT NULL,
  `benefits` TEXT DEFAULT NULL,
  `deliverables` TEXT DEFAULT NULL,
  `ideal_for` TEXT DEFAULT NULL,
  `faqs` TEXT DEFAULT NULL,
  `cta_text` VARCHAR(200) DEFAULT 'Get Started',
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `meta_keywords` VARCHAR(500) DEFAULT NULL,
  `schema_json` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: industries
-- ============================================
CREATE TABLE `industries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `featured_image` VARCHAR(500) DEFAULT NULL,
  `hero_heading` VARCHAR(300) DEFAULT NULL,
  `hero_text` TEXT DEFAULT NULL,
  `pain_points` TEXT DEFAULT NULL,
  `benefits` TEXT DEFAULT NULL,
  `services_offered` TEXT DEFAULT NULL,
  `process_steps` TEXT DEFAULT NULL,
  `faqs` TEXT DEFAULT NULL,
  `cta_text` VARCHAR(200) DEFAULT 'Get Free Audit',
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `meta_keywords` VARCHAR(500) DEFAULT NULL,
  `schema_json` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: packages
-- ============================================
CREATE TABLE `packages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `package_name` VARCHAR(200) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `monthly_price` DECIMAL(10,2) DEFAULT NULL,
  `features` TEXT DEFAULT NULL,
  `delivery_time` VARCHAR(100) DEFAULT NULL,
  `is_highlighted` TINYINT(1) DEFAULT 0,
  `cta_text` VARCHAR(200) DEFAULT 'Get Started',
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: portfolio
-- ============================================
CREATE TABLE `portfolio` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `client_name` VARCHAR(200) DEFAULT NULL,
  `industry` VARCHAR(100) DEFAULT NULL,
  `screenshot` VARCHAR(500) DEFAULT NULL,
  `project_url` VARCHAR(500) DEFAULT NULL,
  `summary` TEXT DEFAULT NULL,
  `tags` VARCHAR(500) DEFAULT NULL,
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: case_studies
-- ============================================
CREATE TABLE `case_studies` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `client_name` VARCHAR(200) DEFAULT NULL,
  `industry` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `challenge` TEXT DEFAULT NULL,
  `strategy` TEXT DEFAULT NULL,
  `work_done` TEXT DEFAULT NULL,
  `result_summary` TEXT DEFAULT NULL,
  `featured_image` VARCHAR(500) DEFAULT NULL,
  `gallery` TEXT DEFAULT NULL,
  `website_url` VARCHAR(500) DEFAULT NULL,
  `google_maps_link` VARCHAR(500) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `schema_json` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: testimonials
-- ============================================
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(200) NOT NULL,
  `business_name` VARCHAR(200) DEFAULT NULL,
  `business_category` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `photo` VARCHAR(500) DEFAULT NULL,
  `rating` TINYINT DEFAULT 5,
  `review` TEXT NOT NULL,
  `video_url` VARCHAR(500) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: blog_categories
-- ============================================
CREATE TABLE `blog_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: blog_posts
-- ============================================
CREATE TABLE `blog_posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(300) NOT NULL,
  `slug` VARCHAR(300) NOT NULL UNIQUE,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `author` VARCHAR(150) DEFAULT 'Bharat SEO Team',
  `featured_image` VARCHAR(500) DEFAULT NULL,
  `content` LONGTEXT DEFAULT NULL,
  `excerpt` TEXT DEFAULT NULL,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `meta_keywords` VARCHAR(500) DEFAULT NULL,
  `canonical_url` VARCHAR(500) DEFAULT NULL,
  `schema_json` TEXT DEFAULT NULL,
  `faqs` TEXT DEFAULT NULL,
  `related_service_id` INT UNSIGNED DEFAULT NULL,
  `related_industry_id` INT UNSIGNED DEFAULT NULL,
  `status` ENUM('draft','published') DEFAULT 'draft',
  `publish_date` DATETIME DEFAULT NULL,
  `views` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `blog_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: leads (contact form enquiries)
-- ============================================
CREATE TABLE `leads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(200) NOT NULL,
  `business_name` VARCHAR(200) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(200) DEFAULT NULL,
  `business_type` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `source_page` VARCHAR(200) DEFAULT NULL,
  `utm_source` VARCHAR(100) DEFAULT NULL,
  `utm_medium` VARCHAR(100) DEFAULT NULL,
  `utm_campaign` VARCHAR(200) DEFAULT NULL,
  `landing_page` VARCHAR(500) DEFAULT NULL,
  `status` ENUM('new','contacted','interested','follow_up','converted','not_interested') DEFAULT 'new',
  `notes` TEXT DEFAULT NULL,
  `follow_up_date` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: audit_requests
-- ============================================
CREATE TABLE `audit_requests` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(200) NOT NULL,
  `business_name` VARCHAR(200) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `whatsapp_number` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(200) DEFAULT NULL,
  `business_type` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `website_url` VARCHAR(500) DEFAULT NULL,
  `google_profile_link` VARCHAR(500) DEFAULT NULL,
  `instagram_link` VARCHAR(500) DEFAULT NULL,
  `main_service` VARCHAR(200) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `utm_source` VARCHAR(100) DEFAULT NULL,
  `utm_medium` VARCHAR(100) DEFAULT NULL,
  `utm_campaign` VARCHAR(200) DEFAULT NULL,
  `landing_page` VARCHAR(500) DEFAULT NULL,
  `status` ENUM('new','auditing','contacted','interested','converted','not_interested') DEFAULT 'new',
  `audit_notes` TEXT DEFAULT NULL,
  `recommended_package` VARCHAR(100) DEFAULT NULL,
  `follow_up_date` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABLE: media
-- ============================================
CREATE TABLE `media` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `file_name` VARCHAR(300) NOT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_type` VARCHAR(50) DEFAULT NULL,
  `file_size` INT UNSIGNED DEFAULT 0,
  `title` VARCHAR(300) DEFAULT NULL,
  `alt_text` VARCHAR(300) DEFAULT NULL,
  `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: csrf_tokens
-- ============================================
CREATE TABLE `csrf_tokens` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `token` VARCHAR(64) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SEED DATA
-- ============================================

-- Default admin user (password: admin123)
INSERT INTO `admin_users` (`username`, `password_hash`, `full_name`, `email`, `must_change_password`) VALUES
('admin', '$2y$12$xAOE5559glCsx8ja2.5TyuoW82Zt8Y2RShVkMRYlqjJBvbcTW.e4K', 'Administrator', 'admin@bharatseo.in', 1);


-- Default site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('agency_name', 'Bharat SEO'),
('tagline', 'Website, Google Map SEO & WhatsApp Leads for Local Businesses'),
('logo', '/assets/images/logo.png'),
('favicon', '/assets/images/favicon.png'),
('primary_color', '#071D49'),
('secondary_color', '#FF8A00'),
('accent_color', '#1B66FF'),
('phone', '+91-XXXXXXXXXX'),
('whatsapp', '+91-XXXXXXXXXX'),
('email', 'hello@bharatseo.in'),
('address', 'India'),
('business_hours', 'Mon-Sat: 10:00 AM - 7:00 PM'),
('google_map_embed', ''),
('instagram_url', 'https://instagram.com/bharatseo'),
('facebook_url', 'https://facebook.com/bharatseo'),
('linkedin_url', 'https://linkedin.com/company/bharatseo'),
('youtube_url', ''),
('footer_text', '© 2024 Bharat SEO. All rights reserved. Helping local businesses grow online.'),
('google_analytics', ''),
('search_console_verification', ''),
('meta_pixel', ''),
('default_meta_title', 'Bharat SEO - Website, Google Map SEO & WhatsApp Leads for Local Businesses'),
('default_meta_description', 'Bharat SEO helps local businesses get more calls, WhatsApp enquiries and customers through professional websites, Local SEO, Google Business Profile optimisation and lead systems.'),
('default_meta_keywords', 'local SEO, Google Map SEO, WhatsApp leads, business website, digital marketing India'),
('canonical_site_url', 'https://bharatseo.in'),
('hero_heading', 'Get More Calls, WhatsApp Enquiries and Customers for Your Business'),
('hero_subheading', 'Bharat SEO helps coaching centres, restaurants, real estate businesses, gyms, clinics and local brands grow online through high-converting websites, Google Map SEO and powerful WhatsApp lead systems.'),
('hero_image', '/assets/images/hero-visual.png');


-- Default SEO settings for pages
INSERT INTO `seo_settings` (`page_key`, `page_name`, `meta_title`, `meta_description`, `robots_meta`) VALUES
('home', 'Home', 'Bharat SEO - Website, Google Map SEO & WhatsApp Leads for Local Businesses', 'Get more calls, WhatsApp enquiries and customers. Professional websites, Local SEO, Google Map ranking and lead systems for local businesses across India.', 'index, follow'),
('about', 'About', 'About Bharat SEO - Digital Growth Partner for Local Businesses', 'Learn about Bharat SEO, our mission, values and how we help local businesses grow online through websites, SEO and lead generation systems.', 'index, follow'),
('services', 'Services', 'Our Services - Bharat SEO | Website, SEO & Lead Generation', 'Explore our services including business website design, Google Map SEO, WhatsApp lead systems, social media marketing and more for local businesses.', 'index, follow'),
('industries', 'Industries', 'Industries We Serve - Bharat SEO | Local Business Marketing', 'We serve coaching centres, restaurants, real estate, gyms, clinics, salons and local shops with targeted digital marketing solutions.', 'index, follow'),
('packages', 'Packages', 'Affordable Packages - Bharat SEO | Plans for Every Local Business', 'Simple and transparent pricing plans for local business growth. Website design, SEO, WhatsApp leads and monthly growth support.', 'index, follow'),
('portfolio', 'Portfolio', 'Our Work - Bharat SEO | Website Design & SEO Portfolio', 'See our latest projects and work for local businesses across India. Website designs, SEO results and digital marketing portfolios.', 'index, follow'),
('case_studies', 'Case Studies', 'Case Studies - Bharat SEO | Real Results for Local Businesses', 'Read how Bharat SEO helped local businesses get more enquiries, calls and customers through websites and digital marketing.', 'index, follow'),
('blog', 'Blog', 'Blog - Bharat SEO | Local Business Marketing Tips & Guides', 'Read expert tips, guides and strategies for local business growth, SEO, Google Map ranking, website design and WhatsApp marketing.', 'index, follow'),
('contact', 'Contact', 'Contact Bharat SEO | Get in Touch for Business Growth', 'Contact Bharat SEO for website design, local SEO, Google Map optimisation and WhatsApp lead systems. Call, WhatsApp or email us.', 'index, follow'),
('free_audit', 'Free Business Audit', 'Free Business Audit - Bharat SEO | Get Your Growth Report', 'Request a free business audit. We analyse your website, Google profile, local SEO and WhatsApp setup to identify growth opportunities.', 'index, follow'),
('thank_you', 'Thank You', 'Thank You - Bharat SEO', 'Your request has been received. Our team will contact you shortly.', 'noindex, nofollow'),
('privacy', 'Privacy Policy', 'Privacy Policy - Bharat SEO', 'Read the privacy policy of Bharat SEO. Learn how we collect, use and protect your information.', 'index, follow'),
('terms', 'Terms & Conditions', 'Terms & Conditions - Bharat SEO', 'Read the terms and conditions for using Bharat SEO services and website.', 'index, follow'),
('disclaimer', 'Disclaimer', 'Disclaimer - Bharat SEO', 'Read our disclaimer regarding services, results and third-party links.', 'index, follow'),
('sitemap_page', 'Sitemap', 'Sitemap - Bharat SEO', 'Browse the complete sitemap of Bharat SEO website.', 'index, follow');


-- Default Services
INSERT INTO `services` (`title`, `slug`, `short_description`, `full_description`, `benefits`, `deliverables`, `ideal_for`, `faqs`, `cta_text`, `sort_order`, `is_active`, `meta_title`, `meta_description`) VALUES
('Website Design & Development', 'website-design-development', 'Professional, mobile-first websites designed to convert visitors into enquiries and customers.', 'We create fast, mobile-friendly, SEO-ready business websites that are designed to generate leads. Every website we build focuses on making it easy for customers to call, WhatsApp or enquire about your services.', '["Fast loading and mobile-optimised","Designed for lead generation","WhatsApp and call buttons built-in","SEO-friendly structure","Easy to update content"]', '["Custom business website","Mobile responsive design","Contact and enquiry forms","WhatsApp integration","Google Map embed","Basic on-page SEO","Social media links"]', '["Local businesses needing their first website","Businesses wanting to upgrade their old website","Service businesses wanting more enquiries"]', '[{"q":"How long does website delivery take?","a":"Most business websites are delivered within 3-7 working days depending on the package."},{"q":"Can I update my website later?","a":"Yes, we build websites that are easy to update or we can manage updates for you."},{"q":"Is hosting included?","a":"Hosting setup guidance is included. We recommend reliable Indian hosting providers."}]', 'Get Your Website', 1, 1, 'Website Design & Development - Bharat SEO', 'Professional business website design for local businesses. Mobile-first, SEO-ready websites that convert visitors into leads.'),

('Google Business Profile Optimisation', 'google-business-profile-optimisation', 'Get your business visible on Google Maps and local search results with a fully optimised Google Business Profile.', 'Your Google Business Profile is often the first thing customers see when they search for your type of business. We optimise every aspect of your profile to improve visibility, build trust and drive calls and visits.', '["Higher visibility on Google Maps","More customer calls and directions","Professional business listing","Review generation support","Regular post updates"]', '["Complete profile setup and optimisation","Business category and description optimisation","Photo uploads and management","Review link creation","Google Posts schedule","Insights monitoring"]', '["Any business with a physical location","Service area businesses","Restaurants, clinics, salons, shops"]', '[{"q":"How long does it take to rank on Google Maps?","a":"Results vary but most businesses see improvement within 4-8 weeks with consistent optimisation."},{"q":"Do I need a website for Google Business Profile?","a":"A website helps but is not mandatory. We can set up your profile even without one."}]', 'Optimise My Profile', 2, 1, 'Google Business Profile Optimisation - Bharat SEO', 'Get more visibility on Google Maps with professional Google Business Profile optimisation for local businesses.'),

('Local SEO & Google Map Ranking', 'local-seo-google-map-ranking', 'Rank higher in local search results so customers in your area find your business first.', 'Local SEO is about making your business the top choice when someone searches for your service in your city or area. We work on your website, Google profile, citations, and content to improve your local rankings.', '["Higher rankings for local searches","More organic traffic","Consistent NAP across platforms","Local citation building","Content optimised for your city"]', '["Local keyword research","On-page SEO optimisation","Google Business Profile SEO","Local citation building","Monthly ranking reports","Content recommendations"]', '["Businesses wanting to rank in their city","Multi-location businesses","Service area businesses"]', '[{"q":"What is local SEO?","a":"Local SEO helps your business appear in search results when people in your area search for services you offer."},{"q":"How is this different from regular SEO?","a":"Local SEO focuses on geographic relevance, Google Maps, and local directories rather than just general keywords."}]', 'Boost Local Rankings', 3, 1, 'Local SEO & Google Map Ranking - Bharat SEO', 'Rank higher on Google Maps and local search results. Local SEO services for businesses across India.');


INSERT INTO `services` (`title`, `slug`, `short_description`, `full_description`, `benefits`, `deliverables`, `ideal_for`, `faqs`, `cta_text`, `sort_order`, `is_active`, `meta_title`, `meta_description`) VALUES
('WhatsApp Lead System', 'whatsapp-lead-system', 'Set up a complete WhatsApp enquiry system so customers can reach you instantly with one tap.', 'WhatsApp is the fastest way for Indian customers to reach a business. We set up click-to-WhatsApp buttons, automated greeting messages, quick replies and integrate WhatsApp CTAs across your website and social media.', '["Instant customer communication","Higher response rates","Automated greetings","Click-to-WhatsApp buttons","WhatsApp link for social media"]', '["WhatsApp Business setup","Click-to-WhatsApp website buttons","Automated greeting message","Quick reply templates","WhatsApp link for social media bios","QR code for offline use"]', '["Any business wanting faster customer communication","Businesses getting enquiries via social media","Service businesses with quick response needs"]', '[{"q":"Do I need WhatsApp Business?","a":"Yes, we set up WhatsApp Business which is free and offers features like automated replies and business profile."},{"q":"Can customers WhatsApp me from my website?","a":"Yes, we add click-to-WhatsApp buttons on your website so customers can message you with one tap."}]', 'Setup WhatsApp Leads', 4, 1, 'WhatsApp Lead System Setup - Bharat SEO', 'Set up a complete WhatsApp enquiry system for your business. Click-to-WhatsApp buttons, automated greetings and lead capture.'),

('Social Media Marketing', 'social-media-marketing', 'Professional social media content and growth strategies to build your brand and attract local customers.', 'We create engaging social media content that builds your brand presence, attracts local followers and drives enquiries. Our focus is on platforms that matter most for local businesses in India.', '["Consistent brand presence","Engaging visual content","Local audience growth","More profile visits","Direct enquiry generation"]', '["Monthly content calendar","Instagram post designs","Story templates","Hashtag strategy","Profile optimisation","Monthly performance review"]', '["Businesses wanting to build brand awareness","Restaurants and cafes","Salons and beauty businesses","Coaching centres"]', '[{"q":"Which platforms do you manage?","a":"We primarily focus on Instagram and Facebook as they drive the most results for local businesses in India."},{"q":"Do you create the content?","a":"Yes, we design posts, write captions and plan your content calendar."}]', 'Start Social Media', 5, 1, 'Social Media Marketing for Local Businesses - Bharat SEO', 'Professional social media marketing for local businesses. Instagram content, growth strategies and brand building.'),

('Instagram Content Design', 'instagram-content-design', 'Eye-catching Instagram posts and stories designed to showcase your business and attract local followers.', 'Instagram is where your customers discover new businesses. We design professional posts, stories and reels templates that make your brand look polished and trustworthy on Instagram.', '["Professional visual identity","Consistent posting schedule","Engaging post designs","Story templates","Brand recognition"]', '["Custom post designs","Story templates","Content calendar","Hashtag research","Bio optimisation","Highlight cover designs"]', '["Restaurants and food businesses","Salons and beauty services","Fitness centres","Fashion and retail"]', '[{"q":"How many posts do you design per month?","a":"Depending on your package, we design 15-30 posts per month along with stories."},{"q":"Do you handle posting too?","a":"Yes, we can manage posting on your behalf or deliver ready-to-post content."}]', 'Get Content Designed', 6, 1, 'Instagram Content Design - Bharat SEO', 'Professional Instagram post and story designs for local businesses. Build your brand on Instagram.'),

('SEO Blog Writing', 'seo-blog-writing', 'Keyword-optimised blog content that drives organic traffic and establishes your authority in local search.', 'Regular blog content helps your website rank for more keywords and establishes your business as an authority. We research keywords, write helpful articles and optimise them for search engines.', '["More organic traffic","Keyword rankings","Authority building","Evergreen content","Support for local SEO"]', '["Keyword research","SEO-optimised articles","Internal linking","Meta tags and descriptions","Image suggestions","Monthly content plan"]', '["Businesses wanting organic traffic","Professional services","Education and coaching","Healthcare and wellness"]', '[{"q":"How often should I publish blogs?","a":"We recommend 2-4 blogs per month for consistent growth in organic traffic."},{"q":"Do you research topics?","a":"Yes, we research keywords and topics relevant to your business and audience."}]', 'Start Blog Content', 7, 1, 'SEO Blog Writing Services - Bharat SEO', 'Professional SEO blog writing for local businesses. Drive organic traffic with keyword-optimised content.'),

('Landing Page Design', 'landing-page-design', 'High-converting landing pages designed for ads and campaigns that turn clicks into enquiries.', 'Running ads without a good landing page wastes money. We design focused landing pages that match your ad message and guide visitors toward taking action - calling, WhatsApp or filling a form.', '["Higher ad conversion rates","Focused messaging","Fast loading pages","Mobile optimised","Clear call-to-action"]', '["Custom landing page design","Mobile responsive layout","Lead capture form","WhatsApp CTA","Call button","Thank you page","Basic tracking setup"]', '["Businesses running Google or Meta ads","Lead generation campaigns","Event or offer promotions"]', '[{"q":"How is a landing page different from a website?","a":"A landing page is a single focused page designed for one goal - getting leads from a specific campaign."},{"q":"Can you connect it to my ads?","a":"Yes, we design landing pages that work with Google Ads, Meta Ads and other platforms."}]', 'Get Landing Page', 8, 1, 'Landing Page Design - Bharat SEO', 'High-converting landing page design for ads and campaigns. Turn clicks into leads for your local business.'),

('Lead Generation Setup', 'lead-generation-setup', 'Complete lead generation systems that capture, track and convert enquiries into customers.', 'We set up end-to-end lead capture systems including forms, WhatsApp buttons, call tracking, and follow-up workflows so you never miss a potential customer.', '["Capture every enquiry","Multiple lead channels","Organised lead tracking","Follow-up reminders","Better conversion rates"]', '["Lead capture forms","WhatsApp lead buttons","Call-to-action setup","Lead notification system","Basic CRM setup","Follow-up workflow"]', '["Service businesses","Real estate businesses","Coaching and education","Healthcare"]', '[{"q":"What is a lead generation system?","a":"It is a setup that captures customer enquiries from multiple channels and helps you follow up and convert them."},{"q":"Will I get notified of new leads?","a":"Yes, you will receive notifications for every new enquiry."}]', 'Setup Lead Generation', 9, 1, 'Lead Generation Setup - Bharat SEO', 'Complete lead generation system setup for local businesses. Capture, track and convert more enquiries.'),

('Online Reputation & Review Growth', 'online-reputation-review-growth', 'Build trust and credibility with a systematic approach to growing positive reviews and managing your online reputation.', 'Online reviews directly influence whether a customer chooses your business. We help you build a system for collecting positive reviews, responding professionally and maintaining a strong online reputation.', '["More positive reviews","Higher star rating","Review response system","Trust building","Social proof"]', '["Review link creation","Review request system","Response templates","Google review growth","Review monitoring","Reputation report"]', '["Any business wanting more reviews","Restaurants and hospitality","Healthcare and clinics","Professional services"]', '[{"q":"How do you get more reviews?","a":"We create easy review links and set up systems that make it simple for happy customers to leave reviews."},{"q":"Do you handle negative reviews?","a":"We provide guidance and templates for responding to negative reviews professionally."}]', 'Grow My Reviews', 10, 1, 'Online Reputation & Review Growth - Bharat SEO', 'Build trust with more positive reviews. Systematic review growth and reputation management for local businesses.');


-- Default Industries
INSERT INTO `industries` (`title`, `slug`, `hero_heading`, `hero_text`, `pain_points`, `benefits`, `faqs`, `cta_text`, `sort_order`, `is_active`, `meta_title`, `meta_description`) VALUES
('Digital Marketing for Coaching Centres', 'coaching-centres', 'Get More Students for Your Coaching Centre', 'Bharat SEO helps coaching centres and institutes attract more students through professional websites, Google visibility and WhatsApp enquiry systems.', '["Students cannot find your coaching centre on Google","Your institute has no professional website","Competitors are getting all the online enquiries","Parents search online but find other options first"]', '["Professional institute website","Google Maps visibility","WhatsApp enquiry setup","Student testimonial showcase","Course page optimisation"]', '[{"q":"How can SEO help my coaching centre?","a":"When parents and students search for coaching in your area, SEO helps your centre appear at the top of results."},{"q":"Do you create websites for institutes?","a":"Yes, we design professional websites specifically for coaching centres and educational institutes."}]', 'Get Free Audit', 1, 1, 'Digital Marketing for Coaching Centres - Bharat SEO', 'Get more students for your coaching centre with professional websites, Google Map SEO and WhatsApp lead systems.'),

('Digital Marketing for Restaurants', 'restaurants', 'Get More Customers for Your Restaurant', 'Bharat SEO helps restaurants, cafes and food businesses attract more dine-in customers and orders through Google visibility, social media and online presence.', '["Customers search for food options but cannot find your restaurant","Your Google listing has few reviews","No professional online presence","Competitors dominate local search results"]', '["Google Maps visibility for food searches","Professional restaurant website","Menu showcase online","Review growth system","Instagram food content","WhatsApp order enquiries"]', '[{"q":"How do you help restaurants get more customers?","a":"We optimise your Google listing, create social media content and build your online presence so hungry customers find you first."},{"q":"Can you help with food delivery visibility?","a":"Yes, we optimise your online presence for both dine-in and delivery searches."}]', 'Get Free Audit', 2, 1, 'Digital Marketing for Restaurants - Bharat SEO', 'Get more customers for your restaurant with Google Map SEO, social media content and professional online presence.'),

('Digital Marketing for Real Estate', 'real-estate', 'Get More Property Enquiries for Your Real Estate Business', 'Bharat SEO helps real estate agents and builders generate qualified property enquiries through targeted landing pages, Google visibility and lead systems.', '["Leads are expensive from property portals","Your website does not generate enquiries","Buyers cannot find your listings on Google","No systematic lead capture system"]', '["High-converting property landing pages","Google visibility for property searches","Lead capture and tracking system","WhatsApp enquiry integration","Project showcase website","Local SEO for your area"]', '[{"q":"How do you generate real estate leads?","a":"We create optimised landing pages, improve your Google visibility and set up lead capture systems for property enquiries."},{"q":"Can you help with new project launches?","a":"Yes, we create dedicated landing pages and digital campaigns for new project launches."}]', 'Get Free Audit', 3, 1, 'Digital Marketing for Real Estate - Bharat SEO', 'Generate more property enquiries with landing pages, Google SEO and lead systems for real estate businesses.'),

('Digital Marketing for Gyms', 'gyms', 'Get More Members for Your Gym or Fitness Centre', 'Bharat SEO helps gyms, fitness centres and personal trainers attract new members through Google visibility, social media presence and enquiry systems.', '["People search for gyms nearby but find competitors","No professional online presence","Membership enquiries are declining","Social media is not generating leads"]', '["Google Maps visibility for gym searches","Professional gym website","Membership enquiry system","Instagram fitness content","Review and testimonial showcase","WhatsApp trial booking"]', '[{"q":"How can digital marketing help my gym?","a":"When people search for gyms in your area, we make sure your gym appears first with compelling information that drives trial visits."},{"q":"Do you create social media content for gyms?","a":"Yes, we design fitness-focused Instagram content that showcases your gym and attracts new members."}]', 'Get Free Audit', 4, 1, 'Digital Marketing for Gyms & Fitness Centres - Bharat SEO', 'Get more members for your gym with Google Map SEO, professional website and social media marketing.'),

('Digital Marketing for Clinics', 'clinics', 'Get More Patients for Your Clinic or Healthcare Practice', 'Bharat SEO helps clinics, doctors and healthcare businesses attract more patients through professional websites, Google visibility and appointment systems.', '["Patients search online but book with other clinics","No professional website or it looks outdated","Google listing is incomplete or has few reviews","No system for appointment enquiries"]', '["Professional healthcare website","Google Maps visibility for clinic searches","Patient appointment system","Review growth for trust building","WhatsApp appointment booking","Health content creation"]', '[{"q":"Is digital marketing appropriate for healthcare?","a":"Absolutely. Most patients search online before choosing a clinic. Being visible and professional online helps build trust."},{"q":"Can you help with patient reviews?","a":"Yes, we set up review collection systems that make it easy for satisfied patients to share their experience."}]', 'Get Free Audit', 5, 1, 'Digital Marketing for Clinics & Healthcare - Bharat SEO', 'Get more patients for your clinic with professional website, Google Map visibility and appointment systems.'),

('Digital Marketing for Salons', 'salons', 'Get More Bookings for Your Salon or Beauty Business', 'Bharat SEO helps salons, spas and beauty businesses attract more bookings through Instagram presence, Google visibility and WhatsApp appointment systems.', '["Customers book with trending salons they find online","Your salon has no Instagram presence","Google listing does not show your best work","No easy booking or enquiry system"]', '["Instagram portfolio showcase","Google Maps visibility for salon searches","WhatsApp booking system","Before-after gallery","Review growth system","Service menu website"]', '[{"q":"How important is Instagram for salons?","a":"Very important. Instagram is where potential customers discover new salons, view work quality and make booking decisions."},{"q":"Can you manage my salon social media?","a":"Yes, we create content showcasing your work, manage posts and help grow your following."}]', 'Get Free Audit', 6, 1, 'Digital Marketing for Salons & Beauty - Bharat SEO', 'Get more bookings for your salon with Instagram content, Google Map SEO and WhatsApp booking systems.'),

('Digital Marketing for Local Shops', 'local-shops', 'Get More Customers for Your Local Shop or Store', 'Bharat SEO helps local shops, retail stores and small businesses attract more footfall and enquiries through Google visibility and digital presence.', '["Customers search online even for local purchases","Your shop does not appear on Google Maps","No way for customers to check products or availability","Competitors have better online presence"]', '["Google Maps visibility for shop searches","Product showcase website","WhatsApp catalogue sharing","Review growth system","Local SEO for your area","Social media presence"]', '[{"q":"Do local shops need digital marketing?","a":"Yes. Even for local purchases, customers search online first. Being visible on Google Maps and having a digital presence drives footfall."},{"q":"Can you help with product showcasing?","a":"Yes, we create simple websites and social media content that showcase your products and services."}]', 'Get Free Audit', 7, 1, 'Digital Marketing for Local Shops - Bharat SEO', 'Get more customers for your local shop with Google Map visibility, product showcase and digital presence.');


-- Default Packages
INSERT INTO `packages` (`package_name`, `price`, `monthly_price`, `features`, `delivery_time`, `is_highlighted`, `cta_text`, `sort_order`) VALUES
('Bharat Starter', 2999.00, NULL, '["1-page mobile-friendly website","WhatsApp enquiry button","Call button","Google Map embed","Contact form","Basic on-page SEO","5 social media post designs","Delivery in 2-3 working days"]', '2-3 working days', 0, 'Start With Starter', 1),
('Bharat Growth', 6999.00, 999.00, '["5-page professional website","Google Business Profile optimisation","WhatsApp lead system","Review link setup","15 Instagram posts per month","Local SEO setup","Monthly report","Delivery in 5-7 working days"]', '5-7 working days', 1, 'Choose Growth', 2),
('Bharat Pro', 14999.00, 2999.00, '["Full premium business website","Landing pages","Blog system","Google Map ranking work","30 Instagram posts per month","Lead tracking","Meta ads setup support","WhatsApp automation basics","Monthly growth report"]', '7-10 working days', 0, 'Talk To Expert', 3);

-- Default Blog Categories
INSERT INTO `blog_categories` (`name`, `slug`, `description`) VALUES
('Local SEO', 'local-seo', 'Tips and guides for improving local search visibility'),
('Website Design', 'website-design', 'Best practices for business website design'),
('Social Media', 'social-media', 'Social media marketing tips for local businesses'),
('Google Business Profile', 'google-business-profile', 'Google Business Profile optimisation guides'),
('WhatsApp Marketing', 'whatsapp-marketing', 'WhatsApp lead generation and marketing tips'),
('Business Growth', 'business-growth', 'General business growth strategies and tips');

-- Sample Testimonials (marked as sample)
INSERT INTO `testimonials` (`client_name`, `business_name`, `business_category`, `city`, `rating`, `review`, `is_active`) VALUES
('Sample Client', 'Sample Coaching Centre', 'Coaching Centre', 'Delhi', 5, 'Bharat SEO built a professional website for our coaching centre and set up our Google Business Profile. We now get regular enquiries from parents searching online. Highly recommended for any coaching institute.', 1),
('Sample Client', 'Sample Restaurant', 'Restaurant', 'Mumbai', 5, 'Our restaurant was invisible on Google Maps. After working with Bharat SEO, we appear in the top results for restaurant searches in our area. The WhatsApp ordering system they set up has been very convenient for customers.', 1),
('Sample Client', 'Sample Clinic', 'Clinic', 'Bangalore', 5, 'The website Bharat SEO created for our clinic looks very professional. Patients often mention they found us on Google. The review system they set up has helped us build trust with new patients.', 1);

-- Sample Case Study (marked as sample)
INSERT INTO `case_studies` (`title`, `slug`, `client_name`, `industry`, `city`, `challenge`, `strategy`, `work_done`, `result_summary`, `is_active`, `meta_title`, `meta_description`) VALUES
('Sample Case Study - Coaching Centre Growth', 'sample-coaching-centre-growth', 'Sample Coaching Centre', 'Coaching Centre', 'Delhi', 'The coaching centre had no online presence and was losing potential students to competitors who appeared on Google.', 'We focused on building a professional website, optimising their Google Business Profile and setting up a WhatsApp enquiry system.', 'Professional 5-page website with course details, Google Business Profile optimisation with photos and posts, WhatsApp lead system, review collection setup.', 'The coaching centre reported increased enquiries from parents who found them online. This is a sample case study for demonstration purposes.', 1, 'Sample Case Study - Coaching Centre Digital Growth', 'How Bharat SEO helped a coaching centre grow online presence and student enquiries.');
