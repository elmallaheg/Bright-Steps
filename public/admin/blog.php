<?php
$adminActive = 'blog';
$pageTitle = 'المدونة';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();

if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: /admin/blog.php'); exit;
}

$posts = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>
<div class="card" style="display:flex;justify-content:space-between;align-items:center">
  <h3 style="margin:0">مقالات المدونة</h3>
  <a href="/admin/blog-edit.php" class="btn">+ مقال جديد</a>
</div>
<div class="card">
  <table>
    <tr><th>العنوان</th><th>الحالة</th><th>التاريخ</th><th></th></tr>
    <?php foreach ($posts as $p): ?>
      <tr>
        <td><?= h($p['title']) ?></td>
        <td><span class="badge <?= $p['status']==='published'?'pub':'draft' ?>"><?= $p['status']==='published'?'منشور':'مسودة' ?></span></td>
        <td><?= date('Y/m/d', strtotime($p['created_at'])) ?></td>
        <td>
          <a href="/admin/blog-edit.php?id=<?= $p['id'] ?>" class="btn secondary">تعديل</a>
          <a href="?delete=<?= $p['id'] ?>" class="btn danger" onclick="return confirm('تأكيد الحذف؟')">حذف</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
