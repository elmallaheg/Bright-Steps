<?php
$adminActive = 'gallery';
$pageTitle = 'معرض الصور';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$uploadDir = __DIR__ . '/../uploads/gallery/';

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("SELECT filename FROM gallery_images WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    $img = $stmt->fetch();
    if ($img && file_exists($uploadDir . $img['filename'])) {
        unlink($uploadDir . $img['filename']);
    }
    $db->prepare("DELETE FROM gallery_images WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: /admin/gallery.php'); exit;
}

// إضافة تصنيف جديد
if (isset($_POST['new_category'])) {
    $name = trim($_POST['new_category']);
    if ($name) {
        $db->prepare("INSERT INTO gallery_categories (name, sort_order) VALUES (?, (SELECT COALESCE(MAX(sort_order),0)+1 FROM gallery_categories c2))")->execute([$name]);
    }
    header('Location: /admin/gallery.php'); exit;
}

// رفع صور (يدعم رفع أكتر من صورة مرة واحدة)
if (isset($_FILES['images'])) {
    $catId = (int)($_POST['category_id'] ?? 0) ?: null;
    $caption = trim($_POST['caption'] ?? '');
    $count = count($_FILES['images']['name']);
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
        $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) continue;
        $filename = 'gallery-' . time() . '-' . rand(1000,9999) . '.' . $ext;
        move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadDir . $filename);
        $db->prepare("INSERT INTO gallery_images (category_id, caption, filename) VALUES (?,?,?)")
           ->execute([$catId, $caption, $filename]);
    }
    header('Location: /admin/gallery.php'); exit;
}

$cats = $db->query("SELECT * FROM gallery_categories ORDER BY sort_order")->fetchAll();
$images = $db->query("SELECT g.*, c.name AS cat_name FROM gallery_images g LEFT JOIN gallery_categories c ON g.category_id=c.id ORDER BY g.uploaded_at DESC")->fetchAll();
?>
<div class="grid2">
  <div class="card">
    <h3>رفع صور جديدة</h3>
    <form method="post" enctype="multipart/form-data">
      <label>التصنيف</label>
      <select name="category_id">
        <option value="">بدون تصنيف</option>
        <?php foreach ($cats as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= h($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <label>وصف مختصر (اختياري، لكل الصور المرفوعة دلوقتي)</label>
      <input type="text" name="caption">
      <label>اختر صورة أو أكتر</label>
      <input type="file" name="images[]" accept="image/*" multiple required>
      <button type="submit" class="btn">رفع</button>
    </form>
  </div>
  <div class="card">
    <h3>تصنيفات المعرض</h3>
    <ul>
      <?php foreach ($cats as $cat): ?><li><?= h($cat['name']) ?></li><?php endforeach; ?>
    </ul>
    <form method="post">
      <label>إضافة تصنيف جديد</label>
      <input type="text" name="new_category" placeholder="مثال: فعاليات نهاية السنة">
      <button type="submit" class="btn secondary">إضافة تصنيف</button>
    </form>
  </div>
</div>

<div class="card">
  <h3>الصور المرفوعة</h3>
  <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px">
    <?php foreach ($images as $img): ?>
      <div>
        <img src="/uploads/gallery/<?= h($img['filename']) ?>" style="width:100%;aspect-ratio:1/1;object-fit:cover;border-radius:10px">
        <div style="font-size:12px;color:#888;margin-top:6px"><?= h($img['cat_name'] ?? 'بدون تصنيف') ?></div>
        <a href="?delete=<?= $img['id'] ?>" onclick="return confirm('تأكيد الحذف؟')" style="font-size:12px;color:#d9534f">حذف</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
