<?php
$adminActive = 'content';
$pageTitle = 'محتوى الصفحات';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE content_blocks SET field_value = ? WHERE id = ?");
    foreach ($_POST['field'] as $id => $val) {
        $stmt->execute([$val, (int)$id]);
    }
    $saved = true;
}

$page = $_GET['page'] ?? 'home';
$pages = ['home' => 'الرئيسية', 'about' => 'عن الحضانة', 'contact' => 'تواصل معنا'];
$rows = $db->prepare("SELECT * FROM content_blocks WHERE page_key = ? ORDER BY id");
$rows->execute([$page]);
$rows = $rows->fetchAll();
?>
<div style="display:flex;gap:10px;margin-bottom:20px">
  <?php foreach ($pages as $key => $label): ?>
    <a href="?page=<?= $key ?>" class="btn <?= $page===$key?'':'secondary' ?>"><?= $label ?></a>
  <?php endforeach; ?>
</div>

<?php if ($saved): ?><div class="alert success">تم حفظ التعديلات.</div><?php endif; ?>

<form method="post">
  <?php foreach ($rows as $row): ?>
    <div class="card">
      <label><?= h($row['field_label']) ?></label>
      <?php if ($row['field_type'] === 'text'): ?>
        <input type="text" name="field[<?= $row['id'] ?>]" value="<?= h($row['field_value']) ?>">
      <?php elseif ($row['field_type'] === 'textarea'): ?>
        <textarea name="field[<?= $row['id'] ?>]" rows="3"><?= h($row['field_value']) ?></textarea>
      <?php elseif ($row['field_type'] === 'richtext'): ?>
        <textarea name="field[<?= $row['id'] ?>]" rows="8"><?= h($row['field_value']) ?></textarea>
        <p style="font-size:12px;color:#999;margin-top:-10px">تقدر تستخدم HTML بسيط زي &lt;b&gt; و&lt;br&gt;.</p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <button type="submit" class="btn">حفظ كل التعديلات</button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
