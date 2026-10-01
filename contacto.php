<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Contacto';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Atencion institucional</p><h1>Contacto</h1></div></section>
<section class="content-page">
    <div class="container content-box">
        <h2><?= e(setting('footer_title', 'Coordinacion Academica')) ?></h2>
        <p><?= nl2br(e(setting('address', 'Blvd. Pedro Infante Cruz 2200 Pte. Col. Recursos Hidraulicos, Culiacan, Sinaloa.'))) ?></p>
        <p><strong>Correo:</strong> <a href="mailto:<?= e(setting('email', 'coordinacion.academica@sepyc.gob.mx')) ?>"><?= e(setting('email', 'coordinacion.academica@sepyc.gob.mx')) ?></a></p>
        <p><strong>Telefono:</strong> <?= e(setting('phone', '(667) 000 0000')) ?></p>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

