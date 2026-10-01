<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Documentos';
$documents = rows('SELECT * FROM documents WHERE is_active = 1 ORDER BY sort_order, id');
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Recursos descargables</p><h1>Documentos</h1></div></section>
<section class="section"><div class="container documents-list">
<?php foreach ($documents as $document): ?>
    <article class="document-item">
        <div><strong><?= e($document['title']) ?></strong><p><?= e($document['description']) ?></p></div>
        <a class="btn" href="<?= e(upload_url($document['file_path'])) ?>" target="_blank" rel="noopener">Descargar</a>
    </article>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

