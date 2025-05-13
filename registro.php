<?php
session_start();
include('db.php');

// Si el usuario ya está logueado, redirigir al índice
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar entradas
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $rol = 'usuario'; // Rol por defecto
    $fecha_registro = date('Y-m-d H:i:s'); // Fecha actual

    // Validaciones
    if (empty($nombre) || empty($correo) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Verificar si el correo ya está registrado
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->execute(['correo' => $correo]);

        if ($stmt->fetch()) {
            $error = "El correo ya está registrado.";
        } else {
            // Encriptar contraseña
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $query = "INSERT INTO usuarios (nombre, correo, contrasena, rol, fecha_creacion) 
                      VALUES (:nombre, :correo, :contrasena, :rol, :fecha)";
            $stmt = $pdo->prepare($query);

            $result = $stmt->execute([
                'nombre' => $nombre,
                'correo' => $correo,
                'contrasena' => $hash_password,
                'rol' => $rol,
                'fecha' => $fecha_registro
            ]);

            if ($result) {
                $success = "Usuario registrado correctamente. Puedes iniciar sesión.";
                header('Location: login.php');
                exit;
            } else {
                $error = "Hubo un problema al registrar el usuario. Intenta nuevamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SPG</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Registro de Usuario</h2>
        <form method="POST" action="registro.php">
            <div class="input-container">
                <label for="nombre">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" required>
            </div>
            <div class="input-container">
                <label for="correo">Correo electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
            </div>
            <div class="input-container">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Registrar</button>
        </form>

        <?php if (isset($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
        <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
    </div>
</body>

</html>