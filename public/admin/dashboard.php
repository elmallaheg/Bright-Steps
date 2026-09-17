<?php
$adminActive = 'dashboard';
$pageTitle = 'الرئيسية';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();
$counts = [
  'programs' => $db->query("SELECT COUNT(*) c FROM programs")->fetch()['c'],
  'posts' => $db->query("SELECT COUNT(*) c FROM blog_posts WHERE status='published'")->fetch()['c'],
  'images' => $db->query("SELECT COUNT(*) c FROM gallery_images")->fetch()['c'],
  'messages' => $db->query("SELECT COUNT(*) c FROM contact_messages WHERE is_read = 0")->fetch()['c'],
];
?>
<div class="grid2" style="grid-template-columns:repeat(4,1fr)">
  <div class="card"><div style="font-size:2rem;font-weight:800;color:var(--teal-dark)"><?= $counts['programs'] ?></div>البرامج</div>
  <div class="card"><div style="font-size:2rem;font-weight:800;color:var(--teal-dark)"><?= $counts['posts'] ?></div>مقالات منشورة</div>
  <div class="card"><div style="font-size:2rem;font-weight:800;color:var(--teal-dark)"><?= $counts['images'] ?></div>صور في المعرض</div>
  <div class="card"><div style="font-size:2rem;font-weight:800;color:var(--teal-dark)"><?= $counts['messages'] ?></div>رسائل جديدة</div>
</div>
<div class="card">
  <h3>خطوات سريعة</h3>
  <p>1. حدّث بيانات التواصل من "إعدادات الموقع".</p>
  <p>2. راجع نصوص "محتوى الصفحات" واستبدل أي حاجة مكتوب فيها [يحتاج تأكيد].</p>
  <p>3. ضيف البرامج الحقيقية من "البرامج" وفعّل النشر.</p>
  <p>4. رفّع صور الأنشطة من "معرض الصور".</p>
  <p>5. اكتب أول مقال من "المدونة".</p>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
