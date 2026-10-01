<?php
require_once __DIR__ . '/includes/functions.php';
$page = row("SELECT * FROM pages WHERE slug = 'nosotros' AND is_active = 1");
$pageTitle = $page['title'] ?? 'Nosotros';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Subsecretaria de Educacion Basica</p><h1><?= e($pageTitle) ?></h1></div></section>
<section class="content-page"><div class="container content-box">
<?= nl2br(e($page['body'] ?? 'La Coordinacion Academica acompana los procesos de planeacion, seguimiento, evaluacion y fortalecimiento pedagogico de Educacion Basica en Sinaloa.')) ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

