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
            $detail = (defined('DEBUG_MODE') && DEBUG_MODE)
                ? '<br><br><strong>Details:</strong> ' . htmlspecialchars($e->getMessage())
                  . '<br><br>Check your database credentials in <code>config.php</code> '
                  . '(DB_HOST, DB_NAME, DB_USER, DB_PASS), and make sure you have imported '
                  . '<code>database.sql</code> or run <a href="/install.php">/install.php</a>.'
                : ' Please check configuration.';
            http_response_code(500);
            die('<div style="font-family:sans-serif;max-width:640px;margin:60px auto;padding:24px;'
                . 'border:1px solid #E5E7EB;border-radius:10px">'
                . '<h2 style="color:#071D49;margin:0 0 8px">Database connection error</h2>'
                . '<p style="color:#475569;line-height:1.6">Bharat SEO could not connect to the database.'
                . $detail . '</p></div>');
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
