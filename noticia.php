<?php
require_once __DIR__ . '/includes/functions.php';
$post = row("SELECT * FROM posts WHERE slug = ? AND status = 'published'", [$_GET['slug'] ?? '']);
if (!$post) {
    http_response_code(404);
    $pageTitle = 'Contenido no encontrado';
} else {
    $pageTitle = $post['title'];
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow"><?= e($post['type'] ?? 'Aviso') ?></p><h1><?= e($post['title'] ?? 'Contenido no encontrado') ?></h1></div></section>
<section class="content-page"><div class="container content-box">
<?php if ($post): ?>
    <p class="date"><?= e(date('M d, Y', strtotime($post['published_at']))) ?></p>
    <img src="<?= e(upload_url($post['image'])) ?>" alt="<?= e($post['title']) ?>" style="border-radius:8px;margin:20px 0;">
    <?= nl2br(e($post['body'])) ?>
<?php else: ?>
    <p>El contenido solicitado no esta disponible.</p>
<?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

