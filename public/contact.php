<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'contact';
$pageTitle = 'تواصل معنا';
$c = get_page_content('contact');
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['parent_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $age = trim($_POST['child_age'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($name && $phone) {
        $stmt = get_db()->prepare("INSERT INTO contact_messages (parent_name, phone, child_age, message) VALUES (?,?,?,?)");
        $stmt->execute([$name, $phone, $age, $msg]);
        $success = true;
    }
}
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container" style="max-width:900px">
    <div class="section-title">
      <h2><?= h($c['intro_title'] ?? '') ?></h2>
      <p><?= h($c['intro_body'] ?? '') ?></p>
    </div>

    <div style="display:grid;grid-template-columns:1.1fr .9fr;gap:40px;align-items:start">
      <div>
        <?php if ($success): ?>
          <div class="notice-missing" style="background:#e6f7ee;border-color:#b8e6cb;color:#1f6b45">
            شكرًا! استلمنا طلبك وهنتواصل معاك قريب.
          </div>
        <?php endif; ?>
        <form class="stack" method="post">
          <div>
            <label>اسم ولي الأمر</label>
            <input type="text" name="parent_name" required>
          </div>
          <div>
            <label>رقم الموبايل</label>
            <input type="tel" name="phone" required>
          </div>
          <div>
            <label>عمر الطفل</label>
            <input type="text" name="child_age">
          </div>
          <div>
            <label>رسالتك</label>
            <textarea name="message" rows="4"></textarea>
          </div>
          <button type="submit" class="btn">إرسال</button>
        </form>
      </div>
      <div class="card">
        <div class="card-body">
          <h3>بيانات التواصل</h3>
          <p>📞 <?= h(get_setting('phone')) ?></p>
          <p>✉️ <?= h(get_setting('email')) ?></p>
          <p>📍 <?= h(get_setting('address')) ?></p>
          <?php if (get_setting('map_embed')): ?>
            <div style="margin-top:16px"><?= get_setting('map_embed') ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
