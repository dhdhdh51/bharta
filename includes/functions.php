<?php
/**
 * Bharat SEO - Helper Functions
 */

/**
 * Sanitize input
 */
function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCsrfToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format Indian price
 */
function formatPrice(float $price): string {
    return '₹' . number_format($price, 0);
}

/**
 * Create URL-friendly slug
 */
function createSlug(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Truncate text
 */
function truncateText(string $text, int $length = 160): string {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length - 3) . '...';
}

/**
 * Get current page URL
 */
function getCurrentUrl(): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Check if current page matches route
 */
function isActivePage(string $route): bool {
    $currentRoute = $_GET['route'] ?? '';
    return $currentRoute === $route || strpos($currentRoute, $route) === 0;
}

/**
 * Get UTM parameters from URL
 */
function getUtmParams(): array {
    return [
        'utm_source' => $_GET['utm_source'] ?? '',
        'utm_medium' => $_GET['utm_medium'] ?? '',
        'utm_campaign' => $_GET['utm_campaign'] ?? '',
        'landing_page' => getCurrentUrl(),
    ];
}

/**
 * Flash message system
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Redirect helper
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * JSON decode helper for stored arrays
 */
function jsonDecode(string $json): array {
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}
