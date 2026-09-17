<?php
require_once __DIR__ . '/../../includes/functions.php';
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $stmt = get_db()->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$u]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($p, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['display_name'] ?: $admin['username'];
        header('Location: /admin/dashboard.php');
        exit;
    }
    $error = 'اسم المستخدم أو كلمة المرور غلط.';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل الدخول - Bright Steps</title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Tajawal',sans-serif;direction:rtl;background:#3F9C90;display:flex;align-items:center;justify-content:center;min-height:100vh}
.box{background:#fff;border-radius:20px;padding:40px;width:360px;box-shadow:0 20px 50px rgba(0,0,0,.2)}
img{display:block;margin:0 auto 20px;height:60px}
input{width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:10px;margin-bottom:14px;font-family:inherit;box-sizing:border-box}
button{width:100%;padding:12px;border:none;border-radius:10px;background:#DD7A3E;color:#fff;font-weight:700;cursor:pointer;font-size:15px}
.error{background:#fdeceb;color:#a33;padding:10px;border-radius:10px;margin-bottom:14px;font-size:14px}
label{font-weight:700;font-size:13px;display:block;margin-bottom:4px}
</style>
</head>
<body>
<div class="box">
  <img src="/assets/img/logo.jpg" alt="Bright Steps">
  <?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
  <form method="post">
    <label>اسم المستخدم</label>
    <input type="text" name="username" required autofocus>
    <label>كلمة المرور</label>
    <input type="password" name="password" required>
    <button type="submit">دخول</button>
  </form>
</div>
</body>
</html>
