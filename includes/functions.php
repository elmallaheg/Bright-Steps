<?php
require_once __DIR__ . '/db.php';

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// جلب كل حقول المحتوى الخاصة بصفحة معينة كمصفوفة field_key => field_value
function get_page_content(string $page_key): array {
    $stmt = get_db()->prepare("SELECT field_key, field_value FROM content_blocks WHERE page_key = ?");
    $stmt->execute([$page_key]);
    $out = [];
    foreach ($stmt->fetchAll() as $row) {
        $out[$row['field_key']] = $row['field_value'];
    }
    return $out;
}

function get_setting(string $key, string $default = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (get_db()->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll() as $row) {
            $cache[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $cache[$key] ?? $default;
}

function get_published_programs(): array {
    return get_db()->query("SELECT * FROM programs WHERE is_published = 1 ORDER BY sort_order ASC")->fetchAll();
}

function get_latest_posts(int $limit = 3): array {
    $stmt = get_db()->prepare("SELECT * FROM blog_posts WHERE status='published' ORDER BY created_at DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_latest_gallery(int $limit = 8): array {
    $stmt = get_db()->prepare("SELECT * FROM gallery_images ORDER BY uploaded_at DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function slugify(string $text): string {
    $text = trim($text);
    // دعم العربي: نسيب الحروف العربية والانجليزية والأرقام بس
    $text = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
    $text = trim($text, '-');
    return $text !== '' ? $text : 'post-' . time();
}
