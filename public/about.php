<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'about';
$pageTitle = 'عن الحضانة';
$c = get_page_content('about');
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container" style="max-width:820px">
    <div class="section-title">
      <h2><?= h($c['philosophy_title'] ?? '') ?></h2>
    </div>
    <?php if (str_contains($c['philosophy_body'] ?? '', 'يحتاج تأكيد')): ?>
      <div class="notice-missing">هذا النص لسه Placeholder — يُستبدل من لوحة التحكم بمحتوى حقيقي عن فلسفة Bright Steps قبل نشر الصفحة للزوار.</div>
    <?php endif; ?>
    <p style="font-size:1.1rem"><?= nl2br(h($c['philosophy_body'] ?? '')) ?></p>

    <div class="section-title" style="margin-top:50px">
      <h2><?= h($c['teachers_title'] ?? '') ?></h2>
    </div>
    <?php if (str_contains($c['teachers_body'] ?? '', 'يحتاج تأكيد')): ?>
      <div class="notice-missing">هذا النص لسه Placeholder — يُستبدل من لوحة التحكم بمعلومات حقيقية عن الفريق قبل النشر.</div>
    <?php endif; ?>
    <p style="font-size:1.1rem"><?= nl2br(h($c['teachers_body'] ?? '')) ?></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
