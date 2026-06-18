<?php
/**
 * Database Connection using PDO
 */
require_once __DIR__ . '/../config.php';

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection error. Please check configuration.");
        }
    }
    return $pdo;
}

/**
 * Get a single site setting
 */
function getSetting(string $key, string $default = ''): string {
    static $settings = null;
    if ($settings === null) {
        $settings = [];
        try {
            $stmt = getDB()->query("SELECT setting_key, setting_value FROM site_settings");
            while ($row = $stmt->fetch()) {
                $settings[$row['setting_key']] = $row['setting_value'] ?? '';
            }
        } catch (PDOException $e) {
            return $default;
        }
    }
    return $settings[$key] ?? $default;
}

/**
 * Get SEO settings for a page
 */
function getSeoSettings(string $pageKey): array {
    try {
        $stmt = getDB()->prepare("SELECT * FROM seo_settings WHERE page_key = ?");
        $stmt->execute([$pageKey]);
        return $stmt->fetch() ?: [];
    } catch (PDOException $e) {
        return [];
    }
}
