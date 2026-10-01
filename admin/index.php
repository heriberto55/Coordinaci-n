<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$sections = [
    'settings' => ['title' => 'Configuracion', 'table' => 'settings'],
    'menu' => ['title' => 'Menu principal', 'table' => 'menu_items'],
    'slides' => ['title' => 'Banners', 'table' => 'slides'],
    'quick' => ['title' => 'Accesos rapidos', 'table' => 'quick_links'],
    'posts' => ['title' => 'Noticias y comunicados', 'table' => 'posts'],
    'documents' => ['title' => 'Documentos', 'table' => 'documents'],
    'pages' => ['title' => 'Paginas', 'table' => 'pages'],
    'events' => ['title' => 'Fechas importantes', 'table' => 'events'],
    'allies' => ['title' => 'Enlaces institucionales', 'table' => 'allies'],
    'users' => ['title' => 'Usuarios', 'table' => 'users'],
];

$fields = [
    'menu' => [
        ['label', 'Etiqueta', 'text'],
        ['url', 'URL', 'text'],
        ['sort_order', 'Orden', 'number'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'slides' => [
        ['title', 'Titulo', 'text'],
        ['subtitle', 'Texto', 'textarea'],
        ['button_text', 'Texto del boton', 'text'],
        ['button_url', 'URL del boton', 'text'],
        ['image', 'Imagen', 'file'],
        ['sort_order', 'Orden', 'number'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'quick' => [
        ['title', 'Titulo', 'text'],
        ['url', 'URL', 'text'],
        ['color', 'Color', 'color'],
        ['sort_order', 'Orden', 'number'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'posts' => [
        ['title', 'Titulo', 'text'],
        ['slug', 'Slug', 'text'],
        ['type', 'Tipo', 'select: Op:comunicado,convocatoria,noticia'],
        ['body', 'Contenido', 'textarea'],
        ['image', 'Imagen', 'file'],
        ['published_at', 'Fecha de publicacion', 'datetime-local'],
        ['status', 'Estado', 'select: Op:published,draft'],
    ],
    'documents' => [
        ['title', 'Titulo', 'text'],
        ['description', 'Descripcion', 'textarea'],
        ['file_path', 'Archivo', 'file'],
        ['sort_order', 'Orden', 'number'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'pages' => [
        ['title', 'Titulo', 'text'],
        ['slug', 'Slug', 'text'],
        ['body', 'Contenido', 'textarea'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'events' => [
        ['title', 'Titulo', 'text'],
        ['description', 'Descripcion', 'textarea'],
        ['event_date', 'Fecha', 'date'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'allies' => [
        ['name', 'Nombre', 'text'],
        ['url', 'URL', 'text'],
        ['image', 'Logotipo', 'file'],
        ['sort_order', 'Orden', 'number'],
        ['is_active', 'Activo', 'checkbox'],
    ],
    'users' => [
        ['name', 'Nombre', 'text'],
        ['username', 'Usuario', 'text'],
        ['password_hash', 'Contrasena nueva', 'password'],
        ['is_active', 'Activo', 'checkbox'],
    ],
];

$section = $_GET['section'] ?? 'settings';
if (!isset($sections[$section])) {
    $section = 'settings';
}

$message = '';
$editing = null;

function redirect_admin(string $section): void
{
    header('Location: index.php?section=' . urlencode($section) . '&saved=1');
    exit;
}

if (isset($_GET['saved'])) {
    $message = 'Cambios guardados correctamente.';
}

if ($section === 'settings' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['settings'] ?? [] as $key => $value) {
        $statement = db()->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
        $statement->execute([$value, $key]);
    }

    foreach (['calendar_image'] as $fileKey) {
        $uploaded = upload_file($fileKey);
        if ($uploaded) {
            $statement = db()->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
            $statement->execute([$uploaded, $fileKey]);
        }
    }

    redirect_admin($section);
}

if ($section !== 'settings' && isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $table = $sections[$section]['table'];
    db()->prepare("DELETE FROM {$table} WHERE id = ?")->execute([$id]);
    redirect_admin($section);
}

if ($section !== 'settings' && isset($_GET['edit'])) {
    $table = $sections[$section]['table'];
    $editing = row("SELECT * FROM {$table} WHERE id = ?", [(int) $_GET['edit']]);
}

if ($section !== 'settings' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $sections[$section]['table'];
    $id = (int) ($_POST['id'] ?? 0);
    $data = [];

    foreach ($fields[$section] as [$name, $label, $type]) {
        if ($type === 'file') {
            $uploaded = upload_file($name);
            $data[$name] = $uploaded ?: ($_POST['current_' . $name] ?? null);
            continue;
        }

        if ($type === 'checkbox') {
            $data[$name] = isset($_POST[$name]) ? 1 : 0;
            continue;
        }

        if ($section === 'users' && $name === 'password_hash') {
            if (!empty($_POST[$name])) {
                $data[$name] = password_hash($_POST[$name], PASSWORD_DEFAULT);
            }
            continue;
        }

        $data[$name] = $_POST[$name] ?? null;
    }

    if ($section === 'posts' && empty($data['slug'])) {
        $data['slug'] = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $data['title']), '-'));
    }

    if ($id > 0) {
        $assignments = implode(', ', array_map(fn($key) => "{$key} = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        db()->prepare("UPDATE {$table} SET {$assignments} WHERE id = ?")->execute($values);
    } else {
        $columns = implode(', ', array_keys($data));
        $marks = implode(', ', array_fill(0, count($data), '?'));
        db()->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$marks})")->execute(array_values($data));
    }

    redirect_admin($section);
}

$settingsRows = $section === 'settings' ? rows('SELECT * FROM settings ORDER BY group_name, setting_key') : [];
$items = $section !== 'settings' ? rows('SELECT * FROM ' . $sections[$section]['table'] . ' ORDER BY id DESC') : [];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS - <?= e($sections[$section]['title']) ?></title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <h1>SEPyC CMS</h1>
        <nav>
            <?php foreach ($sections as $key => $item): ?>
                <a class="<?= $section === $key ? 'active' : '' ?>" href="index.php?section=<?= e($key) ?>"><?= e($item['title']) ?></a>
            <?php endforeach; ?>
            <a href="../index.php" target="_blank">Ver sitio</a>
            <a href="logout.php">Salir</a>
        </nav>
    </aside>
    <main class="admin-main">
        <div class="admin-top">
            <h2><?= e($sections[$section]['title']) ?></h2>
            <span><?= e(admin_user()['name']) ?></span>
        </div>
        <?php if ($message): ?><div class="success"><?= e($message) ?></div><?php endif; ?>

        <?php if ($section === 'settings'): ?>
            <form class="panel" method="post" enctype="multipart/form-data">
                <div class="grid">
                    <?php foreach ($settingsRows as $setting): ?>
                        <label class="<?= strlen($setting['setting_value']) > 80 ? 'full' : '' ?>">
                            <?= e($setting['label']) ?>
                            <?php if ($setting['setting_key'] === 'calendar_image'): ?>
                                <input type="file" name="calendar_image">
                                <span class="hint">Actual: <?= e($setting['setting_value']) ?></span>
                            <?php elseif (strlen($setting['setting_value']) > 80 || strpos($setting['setting_key'], 'text') !== false || strpos($setting['setting_key'], 'address') !== false): ?>
                                <textarea name="settings[<?= e($setting['setting_key']) ?>]"><?= e($setting['setting_value']) ?></textarea>
                            <?php else: ?>
                                <input type="text" name="settings[<?= e($setting['setting_key']) ?>]" value="<?= e($setting['setting_value']) ?>">
                            <?php endif; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit">Guardar configuracion</button>
            </form>
        <?php else: ?>
            <form class="panel" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= e($editing['id'] ?? '') ?>">
                <div class="grid">
                    <?php foreach ($fields[$section] as [$name, $label, $type]): ?>
                        <?php
                        $value = $editing[$name] ?? '';
                        $isFull = in_array($type, ['textarea', 'file'], true) ? 'full' : '';
                        ?>
                        <label class="<?= e($isFull) ?>">
                            <?= e($label) ?>
                            <?php if ($type === 'textarea'): ?>
                                <textarea name="<?= e($name) ?>"><?= e($value) ?></textarea>
                            <?php elseif ($type === 'checkbox'): ?>
                                <input type="checkbox" name="<?= e($name) ?>" value="1" <?= ((string) $value === '1' || (!$editing && $name === 'is_active')) ? 'checked' : '' ?>>
                            <?php elseif ($type === 'file'): ?>
                                <input type="file" name="<?= e($name) ?>">
                                <input type="hidden" name="current_<?= e($name) ?>" value="<?= e($value) ?>">
                                <span class="hint">Actual: <?= e($value) ?></span>
                            <?php elseif (strpos($type, 'select:') === 0): ?>
                                <?php $options = explode(',', substr($type, strlen('select: Op:'))); ?>
                                <select name="<?= e($name) ?>">
                                    <?php foreach ($options as $option): ?>
                                        <option value="<?= e($option) ?>" <?= $value === $option ? 'selected' : '' ?>><?= e($option) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <input type="<?= e($type) ?>" name="<?= e($name) ?>" value="<?= e($value) ?>">
                            <?php endif; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit"><?= $editing ? 'Actualizar' : 'Crear' ?></button>
                <?php if ($editing): ?><a class="btn light" href="index.php?section=<?= e($section) ?>">Cancelar</a><?php endif; ?>
            </form>

            <section class="panel">
                <table>
                    <thead><tr><th>ID</th><th>Contenido</th><th>Estado</th><th>Acciones</th></tr></thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['id']) ?></td>
                            <td>
                                <?php if (!empty($item['image'])): ?><img class="thumb" src="<?= e(upload_url($item['image'])) ?>" alt=""><?php endif; ?>
                                <strong><?= e($item['title'] ?? $item['label'] ?? $item['name'] ?? $item['username'] ?? 'Registro') ?></strong>
                                <p class="hint"><?= e($item['slug'] ?? $item['url'] ?? $item['description'] ?? '') ?></p>
                            </td>
                            <td><?= isset($item['is_active']) ? ($item['is_active'] ? 'Activo' : 'Inactivo') : e($item['status'] ?? '') ?></td>
                            <td class="actions">
                                <a class="btn secondary" href="index.php?section=<?= e($section) ?>&edit=<?= e($item['id']) ?>">Editar</a>
                                <a class="btn danger" href="index.php?section=<?= e($section) ?>&delete=<?= e($item['id']) ?>" onclick="return confirm('Eliminar este registro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
