<?php
require_once __DIR__ . '/includes/functions.php';
$page = row('SELECT * FROM pages WHERE slug = ? AND is_active = 1', [$_GET['slug'] ?? '']);
if (!$page) {
    http_response_code(404);
    $pageTitle = 'Pagina no encontrada';
} else {
    $pageTitle = $page['title'];
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Coordinacion Academica</p><h1><?= e($page['title'] ?? 'Pagina no encontrada') ?></h1></div></section>
<section class="content-page"><div class="container content-box">
<?= $page ? nl2br(e($page['body'])) : '<p>La pagina solicitada no esta disponible.</p>' ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

