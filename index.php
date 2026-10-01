<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = setting('site_name', 'Coordinacion Academica');
$slides = rows('SELECT * FROM slides WHERE is_active = 1 ORDER BY sort_order, id');
$quickLinks = rows('SELECT * FROM quick_links WHERE is_active = 1 ORDER BY sort_order, id LIMIT 5');
$news = rows("SELECT * FROM posts WHERE status = 'published' AND type = 'noticia' ORDER BY published_at DESC, id DESC LIMIT 3");
$comunicados = rows("SELECT * FROM posts WHERE status = 'published' AND type IN ('comunicado','convocatoria') ORDER BY published_at DESC, id DESC LIMIT 3");
$documents = rows('SELECT * FROM documents WHERE is_active = 1 ORDER BY sort_order, id LIMIT 2');
$events = rows('SELECT * FROM events WHERE is_active = 1 ORDER BY event_date ASC, id ASC LIMIT 6');
require __DIR__ . '/includes/header.php';
?>
<section class="hero" aria-label="Banners principales">
    <?php if (!$slides): ?>
        <?php $slides = [[
            'title' => 'Coordinacion Academica',
            'subtitle' => 'Acompanamiento academico, materiales, comunicados y recursos para fortalecer la Educacion Basica en Sinaloa.',
            'button_text' => 'Conocer mas',
            'button_url' => 'nosotros.php',
            'image' => null,
        ]]; ?>
    <?php endif; ?>
    <?php foreach ($slides as $index => $slide): ?>
        <article class="slide <?= $index === 0 ? 'is-active' : '' ?>" data-slide style="background-image:url('<?= e(upload_url($slide['image'])) ?>')">
            <div class="container slide-content">
                <p class="eyebrow">Subsecretaria de Educacion Basica</p>
                <h1><?= e($slide['title']) ?></h1>
                <p><?= e($slide['subtitle']) ?></p>
                <?php if (!empty($slide['button_text'])): ?>
                    <div class="hero-actions">
                        <a class="btn btn-light" href="<?= e($slide['button_url'] ?: '#') ?>"><?= e($slide['button_text']) ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
    <?php if (count($slides) > 1): ?>
        <button class="slide-control prev" type="button" data-slide-control="prev" aria-label="Anterior">‹</button>
        <button class="slide-control next" type="button" data-slide-control="next" aria-label="Siguiente">›</button>
    <?php endif; ?>
</section>

<?php if ($quickLinks): ?>
    <section class="quick-strip" aria-label="Accesos rapidos">
        <?php foreach ($quickLinks as $link): ?>
            <a href="<?= e($link['url']) ?>" style="background: <?= e($link['color']) ?>">
                <span>
                    <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="4" aria-hidden="true"><path d="M12 14h30a10 10 0 0 1 10 10v26H22a10 10 0 0 0-10 10V14Z"/><path d="M12 14v46"/><path d="M22 24h20M22 34h20"/></svg>
                    <?= e($link['title']) ?>
                </span>
            </a>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <h2 class="section-title">Las ultimas noticias</h2>
        <div class="grid-3">
            <?php foreach ($news as $post): ?>
                <article class="card">
                    <a href="noticia.php?slug=<?= e($post['slug']) ?>">
                        <img src="<?= e(upload_url($post['image'])) ?>" alt="<?= e($post['title']) ?>">
                    </a>
                    <div class="card-body">
                        <h3><a href="noticia.php?slug=<?= e($post['slug']) ?>"><?= e($post['title']) ?></a></h3>
                        <p class="date"><?= e(date('M d, Y', strtotime($post['published_at']))) ?></p>
                        <p><?= e(excerpt($post['body'], 130)) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section wine-band">
    <div class="container">
        <h2 class="section-title">Comunicados oficiales</h2>
        <div class="grid-3">
            <?php foreach ($comunicados as $post): ?>
                <article class="card">
                    <a href="noticia.php?slug=<?= e($post['slug']) ?>">
                        <img src="<?= e(upload_url($post['image'])) ?>" alt="<?= e($post['title']) ?>">
                    </a>
                    <div class="card-body">
                        <h3><a href="noticia.php?slug=<?= e($post['slug']) ?>"><?= e($post['title']) ?></a></h3>
                        <p class="date"><?= e(date('M d, Y', strtotime($post['published_at']))) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container feature-row">
        <div class="feature-image">
            <img src="<?= e(upload_url(setting('calendar_image'))) ?>" alt="Calendario escolar">
        </div>
        <div class="feature-copy">
            <h2><?= e(setting('calendar_title', 'Calendario Escolar 2026-2027')) ?></h2>
            <p><?= e(setting('calendar_text', 'Calendario de Educacion Basica vigente para escuelas publicas y particulares incorporadas.')) ?></p>
            <a class="btn btn-dark" href="<?= e(setting('calendar_url', 'documentos.php')) ?>">Descargar</a>
        </div>
    </div>
</section>

<?php if ($events): ?>
    <section class="section">
        <div class="container efemerides">
            <div>
                <h2>Fechas importantes</h2>
                <p>Consulta fechas conmemorativas, actividades academicas y eventos relevantes para la comunidad educativa.</p>
                <a class="btn" href="documentos.php">Ver recursos</a>
            </div>
            <div class="grid-3">
                <?php foreach ($events as $event): ?>
                    <article class="card">
                        <div class="card-body">
                            <p class="date"><?= e(date('d M Y', strtotime($event['event_date']))) ?></p>
                            <h3><?= e($event['title']) ?></h3>
                            <p><?= e($event['description']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($documents): ?>
    <section class="section">
        <div class="container documents-list">
            <?php foreach ($documents as $document): ?>
                <article class="document-item">
                    <strong><?= e($document['title']) ?></strong>
                    <a class="btn" href="<?= e(upload_url($document['file_path'])) ?>" target="_blank" rel="noopener">Descargar</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

