<?php
require_once __DIR__ . '/functions.php';
$menuItems = rows('SELECT label, url FROM menu_items WHERE is_active = 1 ORDER BY sort_order, id');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? setting('site_name', 'Coordinacion Academica')) ?></title>
    <meta name="description" content="<?= e(setting('site_description', 'Coordinacion Academica de la Subsecretaria de Educacion Basica')) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/styles.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="topline"></div>
    <nav class="navbar container" aria-label="Menu principal">
        <a class="brand" href="<?= e(BASE_URL ? rtrim(BASE_URL, '/') . '/' : 'index.php') ?>">
            <span class="brand-mark">SEPyC</span>
            <span class="brand-text">
                <strong><?= e(setting('site_name', 'Coordinacion Academica')) ?></strong>
                <small>Subsecretaria de Educacion Basica</small>
            </span>
        </a>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" data-menu-toggle>
            <span></span><span></span><span></span>
        </button>
        <div class="menu" data-menu>
            <?php foreach ($menuItems as $item): ?>
                <a href="<?= e($item['url']) ?>"><?= e($item['label']) ?></a>
            <?php endforeach; ?>
        </div>
    </nav>
</header>
<main>
