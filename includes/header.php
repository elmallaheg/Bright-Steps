<?php
// $active متاح في كل صفحة لتحديد اللينك النشط في المنيو
$active = $active ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? h($pageTitle) . ' | ' : '' ?><?= h(get_setting('site_name','Bright Steps Child Nursery')) ?></title>
<meta name="description" content="<?= isset($pageDescription) ? h($pageDescription) : 'Bright Steps - حضانة تربّي طفل يعرف يفكر' ?>">
<link rel="icon" href="/assets/img/logo.jpg">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="container">
    <a href="/index.php" class="brand">
      <img src="/assets/img/logo.jpg" alt="Bright Steps Child Nursery">
    </a>
    <nav class="main-nav">
      <a href="/index.php" <?= $active==='home'?'style="color:var(--teal-dark)"':'' ?>>الرئيسية</a>
      <a href="/about.php" <?= $active==='about'?'style="color:var(--teal-dark)"':'' ?>>عن الحضانة</a>
      <a href="/programs.php" <?= $active==='programs'?'style="color:var(--teal-dark)"':'' ?>>البرامج</a>
      <a href="/gallery.php" <?= $active==='gallery'?'style="color:var(--teal-dark)"':'' ?>>معرض الصور</a>
      <a href="/blog.php" <?= $active==='blog'?'style="color:var(--teal-dark)"':'' ?>>المدونة</a>
      <a href="/contact.php" <?= $active==='contact'?'style="color:var(--teal-dark)"':'' ?>>تواصل معنا</a>
    </nav>
    <a href="/contact.php" class="btn btn-sm">احجز زيارة</a>
  </div>
</header>
