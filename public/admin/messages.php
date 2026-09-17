<?php
$adminActive = 'messages';
$pageTitle = 'رسائل التواصل';
require __DIR__ . '/includes/layout_top.php';
$db = get_db();

if (isset($_GET['read'])) {
    $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")->execute([(int)$_GET['read']]);
    header('Location: /admin/messages.php'); exit;
}
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: /admin/messages.php'); exit;
}

$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>
<div class="card">
  <table>
    <tr><th>الاسم</th><th>الموبايل</th><th>عمر الطفل</th><th>الرسالة</th><th>التاريخ</th><th></th></tr>
    <?php foreach ($messages as $m): ?>
      <tr style="<?= $m['is_read']?'opacity:.6':'font-weight:700' ?>">
        <td><?= h($m['parent_name']) ?></td>
        <td><?= h($m['phone']) ?></td>
        <td><?= h($m['child_age']) ?></td>
        <td style="max-width:260px"><?= h($m['message']) ?></td>
        <td><?= date('Y/m/d', strtotime($m['created_at'])) ?></td>
        <td>
          <?php if (!$m['is_read']): ?><a href="?read=<?= $m['id'] ?>" class="btn secondary">تمت القراءة</a><?php endif; ?>
          <a href="?delete=<?= $m['id'] ?>" class="btn danger" onclick="return confirm('تأكيد الحذف؟')">حذف</a>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$messages): ?><tr><td colspan="6">لسه مفيش رسائل.</td></tr><?php endif; ?>
  </table>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
