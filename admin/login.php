<?php
require_once __DIR__ . '/includes/auth.php';

if (admin_user()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = row('SELECT * FROM users WHERE username = ? AND is_active = 1', [$_POST['username'] ?? '']);
    if ($user && verify_admin_password($_POST['password'] ?? '', $user['password_hash'])) {
        $_SESSION['admin_user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'username' => $user['username'],
        ];
        header('Location: index.php');
        exit;
    }

    $error = 'Usuario o contrasena incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso CMS</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="login-screen">
    <form class="login-card" method="post">
        <p class="brand">SEPyC</p>
        <h1>CMS Coordinacion Academica</h1>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <label>Usuario<input type="text" name="username" required autofocus></label>
        <label>Contrasena<input type="password" name="password" required></label>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>

