<?php
require_once __DIR__ . '/../includes/functions.php';
$active = 'home';
$pageTitle = 'الرئيسية';
$c = get_page_content('home');
$programs = get_published_programs();
$posts = get_latest_posts(3);
$gallery = get_latest_gallery(8);
require __DIR__ . '/../includes/header.php';
?>

<section class="hero container">
  <h1><?= h($c['hero_title'] ?? '') ?></h1>
  <p><?= h($c['hero_subtitle'] ?? '') ?></p>
  <div class="hero-actions">
    <a href="/contact.php" class="btn">احجز زيارة</a>
    <a href="/programs.php" class="btn btn-outline">تعرف على البرامج</a>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <h2><?= h($c['pillars_title'] ?? '') ?></h2>
    </div>
    <div class="pillars">
      <div class="pillar-card">
        <div class="dot"></div>
        <h3><?= h($c['pillar1_title'] ?? '') ?></h3>
        <p><?= nl2br(h($c['pillar1_body'] ?? '')) ?></p>
      </div>
      <div class="pillar-card">
        <div class="dot"></div>
        <h3><?= h($c['pillar2_title'] ?? '') ?></h3>
        <p><?= nl2br(h($c['pillar2_body'] ?? '')) ?></p>
      </div>
      <div class="pillar-card">
        <div class="dot"></div>
        <h3><?= h($c['pillar3_title'] ?? '') ?></h3>
        <p><?= nl2br(h($c['pillar3_body'] ?? '')) ?></p>
      </div>
    </div>
  </div>
</section>

<?php if ($programs): ?>
<section class="section section-alt">
  <div class="container">
    <div class="section-title">
      <h2>برامجنا</h2>
      <p>كل مرحلة عمرية ليها احتياجات مختلفة، وبرامجنا مصممة على أساس ده.</p>
    </div>
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
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="container">
    <div class="section-title"><h2><?= h($c['questions_title'] ?? '') ?></h2></div>
    <div class="grid-3">
      <div class="card"><div class="card-body">
        <h3>هل ابني هيكون مرتاح؟</h3>
        <p>الراحة النفسية للطفل بتبني على شعوره بالأمان جوه الفصل، ودي حاجة بنتابعها يوم بيوم مش مرة واحدة بس في البداية.</p>
      </div></div>
      <div class="card"><div class="card-body">
        <h3>هل المدرسين هيفهموا شخصيته؟</h3>
        <p>كل طفل بيتعامل معاه على أساس شخصيته هو، مش نمط واحد بيتطبق على كل الأطفال في الفصل.</p>
      </div></div>
      <div class="card"><div class="card-body">
        <h3>هل هيبقى جاهز للمدرسة؟</h3>
        <p>الاستعداد للمدرسة مش بس معلومات، ده كمان قدرة الطفل إنه يفكر ويحل مشكلة ويعبّر عن نفسه.</p>
      </div></div>
    </div>
  </div>
</section>

<?php if ($gallery): ?>
<section class="section section-alt">
  <div class="container">
    <div class="section-title"><h2>لحظات من يومنا</h2></div>
    <div class="grid-4">
      <?php foreach ($gallery as $g): ?>
        <div class="gallery-item">
          <img src="/uploads/gallery/<?= h($g['filename']) ?>" alt="<?= h($g['caption'] ?? '') ?>">
          <?php if ($g['caption']): ?><div class="cap"><?= h($g['caption']) ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <p style="text-align:center;margin-top:24px"><a href="/gallery.php" class="btn btn-outline">شوف المعرض كامل</a></p>
  </div>
</section>
<?php endif; ?>

<?php if ($posts): ?>
<section class="section">
  <div class="container">
    <div class="section-title"><h2>من المدونة</h2></div>
    <div class="grid-3">
      <?php foreach ($posts as $post): ?>
        <a href="/blog-post.php?slug=<?= h($post['slug']) ?>" class="card">
          <?php if ($post['cover_image']): ?><img class="post-cover" src="/uploads/<?= h($post['cover_image']) ?>" alt=""><?php endif; ?>
          <div class="card-body">
            <h3><?= h($post['title']) ?></h3>
            <p><?= h($post['excerpt']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="container">
    <div class="cta">
      <h2><?= h($c['cta_title'] ?? '') ?></h2>
      <p><?= h($c['cta_body'] ?? '') ?></p>
      <a href="/contact.php" class="btn">تواصل معنا</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
