<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'blog';
$slug = $_GET['slug'] ?? '';
$stmt = get_db()->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$post = $stmt->fetch();
if (!$post) {
    http_response_code(404);
    $pageTitle = 'المقال غير موجود';
    require __DIR__ . '/../includes/header.php';
    echo '<div class="container section"><p>هذا المقال غير موجود أو غير منشور.</p><a href="/blog.php" class="btn">رجوع للمدونة</a></div>';
    require __DIR__ . '/../includes/footer.php';
    exit;
}
$pageTitle = $post['title'];
$pageDescription = $post['excerpt'];
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container post-content">
    <div class="meta"><?= date('Y/m/d', strtotime($post['created_at'])) ?></div>
    <h1 style="color:var(--teal-dark)"><?= h($post['title']) ?></h1>
    <?php if ($post['cover_image']): ?><img class="post-cover" src="/uploads/<?= h($post['cover_image']) ?>" alt=""><?php endif; ?>
    <div><?= $post['content'] ?></div>
    <p style="margin-top:40px"><a href="/blog.php" class="btn btn-outline">رجوع للمدونة</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
