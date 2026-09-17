<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'programs';
$pageTitle = 'البرامج';
$programs = get_published_programs();
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="section-title">
      <h2>برامجنا التعليمية</h2>
      <p>كل مرحلة عمرية ليها طريقة تعامل مختلفة، وده اللي بيحدد شكل البرنامج.</p>
    </div>
    <?php if (!$programs): ?>
      <div class="notice-missing" style="max-width:700px;margin:0 auto">
        لسه مفيش برامج منشورة. من لوحة التحكم → البرامج، ضيف اسم البرنامج والفئة العمرية والوصف الحقيقي، وفعّل "نشر" لكل برنامج يظهر هنا.
      </div>
    <?php else: ?>
      <div class="grid-3">
        <?php foreach ($programs as $p): ?>
          <div class="card">
            <?php if ($p['image']): ?><img src="/uploads/<?= h($p['image']) ?>" alt="<?= h($p['title']) ?>"><?php endif; ?>
            <div class="card-body">
              <?php if ($p['age_range']): ?><span class="tag"><?= h($p['age_range']) ?></span><?php endif; ?>
              <h3><?= h($p['title']) ?></h3>
              <p><?= h($p['description']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
