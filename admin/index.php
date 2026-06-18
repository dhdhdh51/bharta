<?php
/**
 * Admin Panel - Main Router
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Admin session check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    $page = $_GET['page'] ?? '';
    if ($page !== 'login') {
        redirect('/admin/?page=login');
    }
}

$page = $_GET['page'] ?? 'dashboard';

// Force password change
if (isset($_SESSION['admin_logged_in']) && $_SESSION['must_change_password'] && $page !== 'change-password' && $page !== 'logout') {
    redirect('/admin/?page=change-password');
}

// Route admin pages
switch ($page) {
    case 'login':
        require __DIR__ . '/login.php';
        break;
    case 'logout':
        session_destroy();
        redirect('/admin/?page=login');
        break;
    case 'change-password':
        require __DIR__ . '/change-password.php';
        break;
    case 'dashboard':
        require __DIR__ . '/dashboard.php';
        break;
    case 'leads':
        require __DIR__ . '/leads.php';
        break;
    case 'audit-requests':
        require __DIR__ . '/audit-requests.php';
        break;
    case 'services':
        require __DIR__ . '/services.php';
        break;
    case 'industries':
        require __DIR__ . '/industries.php';
        break;
    case 'packages':
        require __DIR__ . '/packages.php';
        break;
    case 'portfolio':
        require __DIR__ . '/portfolio.php';
        break;
    case 'case-studies':
        require __DIR__ . '/case-studies.php';
        break;
    case 'testimonials':
        require __DIR__ . '/testimonials.php';
        break;
    case 'blog':
        require __DIR__ . '/blog.php';
        break;
    case 'seo':
        require __DIR__ . '/seo.php';
        break;
    case 'settings':
        require __DIR__ . '/settings.php';
        break;
    case 'media':
        require __DIR__ . '/media.php';
        break;
    case 'profile':
        require __DIR__ . '/profile.php';
        break;
    default:
        require __DIR__ . '/dashboard.php';
        break;
}
