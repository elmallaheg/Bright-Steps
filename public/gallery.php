<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'gallery';
$pageTitle = 'معرض الصور';
$catId = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$cats = get_db()->query("SELECT * FROM gallery_categories ORDER BY sort_order")->fetchAll();
if ($catId) {
    $stmt = get_db()->prepare("SELECT * FROM gallery_images WHERE category_id = ? ORDER BY uploaded_at DESC");
    $stmt->execute([$catId]);
} else {
    $stmt = get_db()->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
}
$images = $stmt->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="section-title">
      <h2>معرض الصور</h2>
      <p>لحظات حقيقية من أنشطة الأطفال جوه Bright Steps.</p>
    </div>

    <?php if ($cats): ?>
    <div style="display:flex;gap:10px;justify-content:center;margin-bottom:30px;flex-wrap:wrap">
      <a href="/gallery.php" class="btn btn-sm <?= !$catId?'':'btn-outline' ?>">الكل</a>
      <?php foreach ($cats as $cat): ?>
        <a href="/gallery.php?cat=<?= $cat['id'] ?>" class="btn btn-sm <?= $catId==$cat['id']?'':'btn-outline' ?>"><?= h($cat['name']) ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!$images): ?>
      <div class="notice-missing" style="max-width:700px;margin:0 auto">
        لسه مفيش صور مرفوعة. من لوحة التحكم → معرض الصور، رفّع صور فعلية من الأنشطة وحددلها تصنيف وتظهر هنا فورًا.
      </div>
    <?php else: ?>
      <div class="grid-4">
        <?php foreach ($images as $img): ?>
          <div class="gallery-item">
            <img src="/uploads/gallery/<?= h($img['filename']) ?>" alt="<?= h($img['caption'] ?? '') ?>">
            <?php if ($img['caption']): ?><div class="cap"><?= h($img['caption']) ?></div><?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
