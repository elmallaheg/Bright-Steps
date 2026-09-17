<?php
$adminActive = 'programs';
$pageTitle = 'البرامج';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$uploadDir = __DIR__ . '/../uploads/';

// حذف
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM programs WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: /admin/programs.php'); exit;
}

// إضافة/تعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $age = trim($_POST['age_range'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $published = isset($_POST['is_published']) ? 1 : 0;
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $image = 'program-' . time() . '-' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
        }
    }

    if ($id) {
        if ($image) {
            $db->prepare("UPDATE programs SET title=?, age_range=?, description=?, is_published=?, image=? WHERE id=?")
               ->execute([$title, $age, $desc, $published, $image, $id]);
        } else {
            $db->prepare("UPDATE programs SET title=?, age_range=?, description=?, is_published=? WHERE id=?")
               ->execute([$title, $age, $desc, $published, $id]);
        }
    } else {
        $db->prepare("INSERT INTO programs (title, age_range, description, is_published, image, sort_order) VALUES (?,?,?,?,?, (SELECT COALESCE(MAX(sort_order),0)+1 FROM programs p2))")
           ->execute([$title, $age, $desc, $published, $image]);
    }
    header('Location: /admin/programs.php'); exit;
}

$editId = (int)($_GET['edit'] ?? 0);
$editing = null;
if ($editId) {
    $stmt = $db->prepare("SELECT * FROM programs WHERE id = ?");
    $stmt->execute([$editId]);
    $editing = $stmt->fetch();
}
$programs = $db->query("SELECT * FROM programs ORDER BY sort_order")->fetchAll();
?>

<div class="card">
  <h3><?= $editing ? 'تعديل برنامج' : 'إضافة برنامج جديد' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $editing['id'] ?? '' ?>">
    <label>اسم البرنامج</label>
    <input type="text" name="title" value="<?= h($editing['title'] ?? '') ?>" required>
    <label>الفئة العمرية (مثال: من 2 إلى 3 سنوات)</label>
    <input type="text" name="age_range" value="<?= h($editing['age_range'] ?? '') ?>">
    <label>الوصف</label>
    <textarea name="description" rows="3"><?= h($editing['description'] ?? '') ?></textarea>
    <label>صورة (اختياري)</label>
    <input type="file" name="image" accept="image/*">
    <label style="display:flex;align-items:center;gap:8px;font-weight:400">
      <input type="checkbox" name="is_published" style="width:auto" <?= (!$editing || $editing['is_published']) ? 'checked':'' ?>> نشر هذا البرنامج على الموقع
    </label>
    <button type="submit" class="btn"><?= $editing ? 'حفظ التعديل' : 'إضافة' ?></button>
    <?php if ($editing): ?><a href="/admin/programs.php" class="btn secondary">إلغاء</a><?php endif; ?>
  </form>
</div>

<div class="card">
  <table>
    <tr><th>صورة</th><th>الاسم</th><th>العمر</th><th>الحالة</th><th></th></tr>
    <?php foreach ($programs as $p): ?>
      <tr>
        <td><?php if ($p['image']): ?><img class="thumb" src="/uploads/<?= h($p['image']) ?>"><?php endif; ?></td>
        <td><?= h($p['title']) ?></td>
        <td><?= h($p['age_range']) ?></td>
        <td><span class="badge <?= $p['is_published']?'pub':'draft' ?>"><?= $p['is_published']?'منشور':'غير منشور' ?></span></td>
        <td>
          <a href="?edit=<?= $p['id'] ?>" class="btn secondary">تعديل</a>
          <a href="?delete=<?= $p['id'] ?>" class="btn danger" onclick="return confirm('تأكيد الحذف؟')">حذف</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
