<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'blog';
$pageTitle = 'المدونة';
$posts = get_db()->query("SELECT * FROM blog_posts WHERE status='published' ORDER BY created_at DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="section-title">
      <h2>المدونة</h2>
      <p>مقالات عن التربية والتعلم من واقع خبرتنا مع الأطفال يوميًا.</p>
    </div>
    <?php if (!$posts): ?>
      <div class="notice-missing" style="max-width:700px;margin:0 auto">
        لسه مفيش مقالات منشورة. من لوحة التحكم → المدونة، اكتب أول مقال وانشره.
      </div>
    <?php else: ?>
      <div class="grid-3">
        <?php foreach ($posts as $post): ?>
          <a href="/blog-post.php?slug=<?= h($post['slug']) ?>" class="card">
            <?php if ($post['cover_image']): ?><img class="post-cover" src="/uploads/<?= h($post['cover_image']) ?>" alt=""><?php endif; ?>
            <div class="card-body">
              <div class="meta"><?= date('Y/m/d', strtotime($post['created_at'])) ?></div>
              <h3><?= h($post['title']) ?></h3>
              <p><?= h($post['excerpt']) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
