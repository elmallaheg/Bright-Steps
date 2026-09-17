<?php
$adminActive = 'blog';
$pageTitle = 'مقال';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$uploadDir = __DIR__ . '/../uploads/';

$id = (int)($_GET['id'] ?? 0);
$post = null;
if ($id) {
    $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] === 'published' ? 'published' : 'draft';
    $cover = $post['cover_image'] ?? null;

    if (!empty($_FILES['cover_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $cover = 'post-' . time() . '-' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $cover);
        }
    }

    if ($post) {
        $slug = $post['slug'];
        $db->prepare("UPDATE blog_posts SET title=?, excerpt=?, content=?, status=?, cover_image=? WHERE id=?")
           ->execute([$title, $excerpt, $content, $status, $cover, $post['id']]);
    } else {
        $slug = slugify($title);
        // تأكد الslug فريد
        $base = $slug; $i = 1;
        while (true) {
            $chk = $db->prepare("SELECT id FROM blog_posts WHERE slug = ?");
            $chk->execute([$slug]);
            if (!$chk->fetch()) break;
            $slug = $base . '-' . (++$i);
        }
        $db->prepare("INSERT INTO blog_posts (title, slug, excerpt, content, status, cover_image) VALUES (?,?,?,?,?,?)")
           ->execute([$title, $slug, $excerpt, $content, $status, $cover]);
    }
    header('Location: /admin/blog.php'); exit;
}
?>
<div class="card">
  <form method="post" enctype="multipart/form-data">
    <label>عنوان المقال</label>
    <input type="text" name="title" value="<?= h($post['title'] ?? '') ?>" required>
    <label>مقدمة قصيرة (تظهر في قائمة المدونة)</label>
    <textarea name="excerpt" rows="2"><?= h($post['excerpt'] ?? '') ?></textarea>
    <label>نص المقال (تقدر تستخدم فقرات وHTML بسيط)</label>
    <textarea name="content" rows="14"><?= h($post['content'] ?? '') ?></textarea>
    <label>صورة الغلاف</label>
    <?php if (!empty($post['cover_image'])): ?><img class="thumb" src="/uploads/<?= h($post['cover_image']) ?>" style="margin-bottom:10px"><?php endif; ?>
    <input type="file" name="cover_image" accept="image/*">
    <label>الحالة</label>
    <select name="status">
      <option value="draft" <?= (!$post || $post['status']==='draft')?'selected':'' ?>>مسودة</option>
      <option value="published" <?= ($post && $post['status']==='published')?'selected':'' ?>>منشور</option>
    </select>
    <button type="submit" class="btn">حفظ</button>
    <a href="/admin/blog.php" class="btn secondary">رجوع</a>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
