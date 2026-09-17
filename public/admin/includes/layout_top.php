<?php
require_once __DIR__ . '/auth.php';
require_login();
$adminActive = $adminActive ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? h($pageTitle).' | ' : '' ?>لوحة تحكم Bright Steps</title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<style>
:root{--teal:#3F9C90;--teal-dark:#2A7C71;--orange:#DD7A3E;--yellow:#F0A93B;--pink:#F0A79E;--cream:#FBEFE2;--ink:#3A342C;}
*{box-sizing:border-box}
body{margin:0;font-family:'Tajawal',sans-serif;direction:rtl;background:#F4F2EE;color:var(--ink)}
.wrap{display:flex;min-height:100vh}
.sidebar{width:230px;background:var(--teal-dark);color:#fff;padding:24px 16px;flex-shrink:0}
.sidebar h2{font-size:1.1rem;margin:0 0 24px}
.sidebar a{display:block;color:#fff;opacity:.85;text-decoration:none;padding:10px 12px;border-radius:10px;margin-bottom:4px;font-weight:600}
.sidebar a.active,.sidebar a:hover{background:rgba(255,255,255,.15);opacity:1}
.main{flex:1;padding:30px 40px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
.card{background:#fff;border-radius:16px;padding:24px;box-shadow:0 8px 24px rgba(0,0,0,.05);margin-bottom:24px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px 12px;text-align:right;border-bottom:1px solid #eee;font-size:14px}
th{color:#888;font-weight:700}
.btn{display:inline-block;padding:10px 20px;border-radius:10px;background:var(--orange);color:#fff;border:none;font-weight:700;cursor:pointer;text-decoration:none;font-size:14px}
.btn.secondary{background:#e9e6e0;color:var(--ink)}
.btn.danger{background:#d9534f}
input,textarea,select{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:10px;font-family:inherit;margin-bottom:14px;font-size:14px}
label{font-weight:700;font-size:13px;display:block;margin-bottom:4px}
.alert{padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:14px}
.alert.success{background:#e6f7ee;color:#1f6b45}
.badge{padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700}
.badge.pub{background:#e6f7ee;color:#1f6b45}
.badge.draft{background:#fdf1de;color:#a0680f}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
img.thumb{width:70px;height:70px;object-fit:cover;border-radius:8px}
</style>
</head>
<body>
<div class="wrap">
  <aside class="sidebar">
    <h2>🌤️ Bright Steps</h2>
    <a href="/admin/dashboard.php" class="<?= $adminActive==='dashboard'?'active':'' ?>">الرئيسية</a>
    <a href="/admin/content.php" class="<?= $adminActive==='content'?'active':'' ?>">محتوى الصفحات</a>
    <a href="/admin/programs.php" class="<?= $adminActive==='programs'?'active':'' ?>">البرامج</a>
    <a href="/admin/blog.php" class="<?= $adminActive==='blog'?'active':'' ?>">المدونة</a>
    <a href="/admin/gallery.php" class="<?= $adminActive==='gallery'?'active':'' ?>">معرض الصور</a>
    <a href="/admin/messages.php" class="<?= $adminActive==='messages'?'active':'' ?>">رسائل التواصل</a>
    <a href="/admin/settings.php" class="<?= $adminActive==='settings'?'active':'' ?>">إعدادات الموقع</a>
    <a href="/admin/logout.php" style="margin-top:30px;opacity:.6">خروج</a>
  </aside>
  <main class="main">
    <div class="topbar">
      <div></div>
      <div>أهلاً، <?= h(current_admin_name()) ?></div>
    </div>
