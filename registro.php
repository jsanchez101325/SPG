<?php
session_start();
include('db.php');

// Si el usuario ya está logueado, redirigir al índice
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $rol = 'usuario'; // Rol forzado desde el backend

    // Validar campos requeridos
    if (empty($nombre) || empty($correo) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Validar que el correo tenga un formato correcto
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = "El correo electrónico no es válido.";
        } else {
            // Verificar si el correo ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
            $stmt->execute(['correo' => $correo]);

            if ($stmt->fetch()) {
                $error = "El correo ya está registrado.";
            } else {
                // Hash de la contraseña
                $hash_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario (sin 'rol' como parámetro en el formulario)
                $query = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
                          VALUES (:nombre, :correo, :contraseña, :rol)";
                $stmt = $pdo->prepare($query);

                // Verificar si la inserción fue exitosa
                if ($stmt->execute([
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'contraseña' => $hash_password,
                    'rol' => $rol // No se pasa desde el formulario, siempre será 'usuario'
                ])) {
                    $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
                } else {
                    $error = "Hubo un problema al registrar el usuario. Intenta nuevamente.";
                }
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