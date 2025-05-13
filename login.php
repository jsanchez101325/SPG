<?php
session_start();
include('db.php'); // Asegúrate de que $pdo esté correctamente configurado

// Si el usuario ya está logueado, redirigir a la app principal
if (isset($_SESSION['user_id'])) {
    header('Location: app.php');
    exit;
}

$error = ''; // Variable para mostrar mensajes de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($correo) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $query = "SELECT * FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña usando password_verify()
        if ($user && password_verify($password, $user['contrasena'])) {
            // Establecer variables de sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];

            // Redirigir al sistema
            header('Location: app.php');
            exit;
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SPG</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="login.php">
            <div class="input-container">
                <label for="correo">Correo electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
            </div>
            <div class="input-container">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Entrar</button>
        </form>

        <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <p>¿No tienes cuenta? <a href="registro.php">Registrar</a></p>
    </div>
</body>

</html>