<?php
$adminActive = 'settings';
$pageTitle = 'إعدادات الموقع';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
    foreach ($_POST['setting'] as $key => $val) {
        $stmt->execute([$val, $key]);
    }
    $saved = true;
}

$labels = [
    'site_name' => 'اسم الحضانة',
    'phone' => 'رقم التليفون',
    'whatsapp' => 'رقم الواتساب',
    'email' => 'البريد الإلكتروني',
    'address' => 'العنوان',
    'facebook' => 'رابط فيسبوك',
    'instagram' => 'رابط إنستجرام',
    'tiktok' => 'رابط تيك توك',
    'map_embed' => 'كود خريطة جوجل (Embed)',
];
$rows = $db->query("SELECT * FROM site_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<?php if ($saved): ?><div class="alert success">تم حفظ الإعدادات.</div><?php endif; ?>
<div class="card">
  <form method="post">
    <?php foreach ($labels as $key => $label): ?>
      <label><?= $label ?></label>
      <?php if ($key === 'map_embed'): ?>
        <textarea name="setting[<?= $key ?>]" rows="3"><?= h($rows[$key] ?? '') ?></textarea>
      <?php else: ?>
        <input type="text" name="setting[<?= $key ?>]" value="<?= h($rows[$key] ?? '') ?>">
      <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit" class="btn">حفظ</button>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
