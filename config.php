<?php
/**
 * Bharat SEO - Configuration File
 * Copy this file and update database credentials for your server.
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bharat_seo');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_URL', 'https://bharatseo.in');
define('SITE_NAME', 'Bharat SEO');
define('ADMIN_PATH', '/admin');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', '/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB

// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
