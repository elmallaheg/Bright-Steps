<footer>
  <div class="container">
    <div class="col">
      <img src="/assets/img/logo.jpg" alt="Bright Steps" style="height:50px;margin-bottom:14px;border-radius:0">
      <p style="opacity:.75;font-size:14px;max-width:260px">حضانة بتساعد طفلك يفهم الدنيا حواليه بنفسه، مش بس ياخد إجابات جاهزة.</p>
    </div>
    <div class="col">
      <h4>روابط</h4>
      <p><a href="/about.php">عن الحضانة</a></p>
      <p><a href="/programs.php">البرامج</a></p>
      <p><a href="/blog.php">المدونة</a></p>
      <p><a href="/gallery.php">معرض الصور</a></p>
    </div>
    <div class="col">
      <h4>تواصل معنا</h4>
      <p><?= h(get_setting('phone')) ?></p>
      <p><?= h(get_setting('email')) ?></p>
      <p><?= h(get_setting('address')) ?></p>
    </div>
    <div class="col">
      <h4>تابعونا</h4>
      <p>
        <?php if (get_setting('facebook')): ?><a href="<?= h(get_setting('facebook')) ?>" target="_blank">فيسبوك</a> · <?php endif; ?>
        <?php if (get_setting('instagram')): ?><a href="<?= h(get_setting('instagram')) ?>" target="_blank">إنستجرام</a> · <?php endif; ?>
        <?php if (get_setting('tiktok')): ?><a href="<?= h(get_setting('tiktok')) ?>" target="_blank">تيك توك</a><?php endif; ?>
      </p>
    </div>
  </div>
  <div class="footer-bottom">© <?= date('Y') ?> Bright Steps Child Nursery. جميع الحقوق محفوظة.</div>
</footer>
</body>
</html>
