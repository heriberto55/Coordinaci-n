<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Convocatorias y comunicados';
$posts = rows("SELECT * FROM posts WHERE status = 'published' AND type IN ('convocatoria','comunicado') ORDER BY published_at DESC, id DESC");
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Informacion oficial</p><h1>Convocatorias y comunicados</h1></div></section>
<section class="section wine-band"><div class="container grid-3">
<?php foreach ($posts as $post): ?>
    <article class="card">
        <a href="noticia.php?slug=<?= e($post['slug']) ?>"><img src="<?= e(upload_url($post['image'])) ?>" alt="<?= e($post['title']) ?>"></a>
        <div class="card-body"><h3><a href="noticia.php?slug=<?= e($post['slug']) ?>"><?= e($post['title']) ?></a></h3><p class="date"><?= e(date('M d, Y', strtotime($post['published_at']))) ?></p></div>
    </article>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

