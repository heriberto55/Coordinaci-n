<?php
$allies = rows('SELECT name, url, image FROM allies WHERE is_active = 1 ORDER BY sort_order, id');
?>
</main>
<footer class="site-footer">
    <?php if ($allies): ?>
        <section class="allies">
            <div class="container allies-grid">
                <?php foreach ($allies as $ally): ?>
                    <a href="<?= e($ally['url']) ?>" target="_blank" rel="noopener">
                        <?php if ($ally['image']): ?>
                            <img src="<?= e(upload_url($ally['image'])) ?>" alt="<?= e($ally['name']) ?>">
                        <?php else: ?>
                            <span><?= e($ally['name']) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <div class="footer-main">
        <div class="footer-wave" aria-hidden="true"></div>
        <div class="container footer-grid">
            <div>
                <div class="footer-logo">SEPyC</div>
                <p><?= e(setting('footer_department', 'Secretaria de Educacion Publica y Cultura')) ?></p>
            </div>
            <div>
                <h2><?= e(setting('footer_title', 'Coordinacion Academica')) ?></h2>
                <p><?= nl2br(e(setting('address', 'Blvd. Pedro Infante Cruz 2200 Pte. Col. Recursos Hidraulicos, Culiacan, Sinaloa.'))) ?></p>
            </div>
            <div>
                <h2>Siguenos</h2>
                <div class="social">
                    <a href="<?= e(setting('facebook_url', '#')) ?>" aria-label="Facebook">f</a>
                    <a href="<?= e(setting('youtube_url', '#')) ?>" aria-label="YouTube">▶</a>
                    <a href="<?= e(setting('x_url', '#')) ?>" aria-label="X">X</a>
                </div>
            </div>
        </div>
        <div class="container legal">
            <a href="#">Aviso de Privacidad</a>
            <span>|</span>
            <a href="#">SEPyC - SEPDES</a>
            <span>|</span>
            <a href="#">Gobierno del Estado de Sinaloa</a>
        </div>
    </div>
</footer>
<script src="<?= e(asset('js/main.js')) ?>"></script>
</body>
</html>

