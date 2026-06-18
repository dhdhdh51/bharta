<?php
/**
 * Form submission handler
 */

$formType = $_POST['form_type'] ?? '';
$csrfToken = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrfToken)) {
    setFlash('error', 'Security verification failed. Please try again.');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

switch ($formType) {
    case 'contact':
        handleContactForm();
        break;
    case 'audit':
        handleAuditForm();
        break;
    default:
        redirect('/');
}

function handleContactForm(): void {
    $data = [
        'name' => sanitize($_POST['name'] ?? ''),
        'business_name' => sanitize($_POST['business_name'] ?? ''),
        'phone' => sanitize($_POST['phone'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'business_type' => sanitize($_POST['business_type'] ?? ''),
        'city' => sanitize($_POST['city'] ?? ''),
        'message' => sanitize($_POST['message'] ?? ''),
        'source_page' => sanitize($_POST['source_page'] ?? ''),
    ];

    $utm = getUtmParams();

    if (empty($data['name']) || empty($data['phone'])) {
        setFlash('error', 'Please provide your name and phone number.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/contact');
    }

    try {
        $stmt = getDB()->prepare("INSERT INTO leads (name, business_name, phone, email, business_type, city, message, source_page, utm_source, utm_medium, utm_campaign, landing_page) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['name'], $data['business_name'], $data['phone'], $data['email'],
            $data['business_type'], $data['city'], $data['message'], $data['source_page'],
            $utm['utm_source'], $utm['utm_medium'], $utm['utm_campaign'], $utm['landing_page']
        ]);
        redirect('/thank-you');
    } catch (PDOException $e) {
        error_log("Contact form error: " . $e->getMessage());
        setFlash('error', 'Something went wrong. Please try again.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/contact');
    }
}

function handleAuditForm(): void {
    $data = [
        'name' => sanitize($_POST['name'] ?? ''),
        'business_name' => sanitize($_POST['business_name'] ?? ''),
        'phone' => sanitize($_POST['phone'] ?? ''),
        'whatsapp_number' => sanitize($_POST['whatsapp_number'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'business_type' => sanitize($_POST['business_type'] ?? ''),
        'city' => sanitize($_POST['city'] ?? ''),
        'website_url' => sanitize($_POST['website_url'] ?? ''),
        'google_profile_link' => sanitize($_POST['google_profile_link'] ?? ''),
        'instagram_link' => sanitize($_POST['instagram_link'] ?? ''),
        'main_service' => sanitize($_POST['main_service'] ?? ''),
        'message' => sanitize($_POST['message'] ?? ''),
    ];

    $utm = getUtmParams();

    if (empty($data['name']) || empty($data['phone'])) {
        setFlash('error', 'Please provide your name and phone number.');
        redirect('/free-audit');
    }

    try {
        $stmt = getDB()->prepare("INSERT INTO audit_requests (name, business_name, phone, whatsapp_number, email, business_type, city, website_url, google_profile_link, instagram_link, main_service, message, utm_source, utm_medium, utm_campaign, landing_page) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['name'], $data['business_name'], $data['phone'], $data['whatsapp_number'],
            $data['email'], $data['business_type'], $data['city'], $data['website_url'],
            $data['google_profile_link'], $data['instagram_link'], $data['main_service'],
            $data['message'], $utm['utm_source'], $utm['utm_medium'], $utm['utm_campaign'],
            $utm['landing_page']
        ]);
        redirect('/thank-you');
    } catch (PDOException $e) {
        error_log("Audit form error: " . $e->getMessage());
        setFlash('error', 'Something went wrong. Please try again.');
        redirect('/free-audit');
    }
}
