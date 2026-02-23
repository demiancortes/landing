<?php
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
error_reporting(E_ALL);

unset($_SESSION['login_attempts']);

// =============================
// CONFIGURACIÓN
// =============================

define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$2y$10$XE6opzCwGwSyny4HfDoSQO0ZsIqfk05OYeMpc3EG7YzRPnxPGb8qi');

// =============================
// PROTECCIÓN BÁSICA
// =============================

if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;

if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));

$error = "";

// =============================
// PROCESAR LOGIN
// =============================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("Token inválido.");

    if ($_SESSION['login_attempts'] >= 5) {
        $error = "Demasiados intentos. Recarga la página.";
    } else {

        $user = isset($_POST["user"]) ? trim($_POST["user"]) : "";
        $pass = isset($_POST["pass"]) ? trim($_POST["pass"]) : "";

        if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS_HASH)) {
            session_regenerate_id(true);
            $_SESSION["admin_logged"] = true;
            $_SESSION['login_attempts'] = 0;
            header("Location: editor.php");
            exit;
        } else {
            $_SESSION['login_attempts']++;
            $error = "Credenciales incorrectas";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acceso al panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="alternate icon" href="../images/ui/logo.svg">
<link rel="stylesheet" href="../css/styles.css">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-login-container">

    <div class="admin-wrapper admin-login-card">

        <h1>Acceso al panel</h1>
        <span class="admin-help">
            Ingresa tus credenciales para administrar el sitio.
        </span>

        <?php if ($error): ?>
            <p class="admin-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="admin-group">
                <label>Usuario</label>
                <input type="text" name="user" required>
            </div>

            <div class="admin-group">
                <label>Contraseña</label>
                <input type="password" name="pass" required>
            </div>

            <div class="admin-actions">
                <button class="btn-admin" type="submit">
                    Entrar
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
