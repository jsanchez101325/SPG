<?php
include('db.php');

// Consulta para obtener los proyectos disponibles
$query_proyectos = "SELECT id, nombre FROM proyectos";
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los usuarios disponibles
$query_usuarios = "SELECT id, nombre FROM usuarios";
$stmt_usuarios = $pdo->query($query_usuarios);
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proyecto_id = $_POST['proyecto_id'];
    $mensaje = $_POST['mensaje'];
    $usuario_id = $_POST['usuario_id'];

    // Inserta el nuevo mensaje en la tabla de comunicaciones
    $query = "INSERT INTO comunicacion (proyecto_id, mensaje, fecha, usuario_id) 
              VALUES (:proyecto_id, :mensaje, NOW(), :usuario_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':proyecto_id' => $proyecto_id,
        ':mensaje' => $mensaje,
        ':usuario_id' => $usuario_id
    ]);

    echo "Mensaje de comunicación enviado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comunicación - SPG</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Incluir el header -->
    <?php include('header.php'); ?>

    <main>
        <h2>Formulario para Enviar Mensaje de Comunicación</h2>
        <form action="comunicacion.php" method="POST">
            <div>
                <label for="proyecto_id">Proyecto</label>
                <select id="proyecto_id" name="proyecto_id" required>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <option value="<?php echo $proyecto['id']; ?>"><?php echo htmlspecialchars($proyecto['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
            </div>

            <div>
                <label for="usuario_id">Usuario</label>
                <select id="usuario_id" name="usuario_id" required>
                    <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <button type="submit">Enviar Mensaje</button>
            </div>
        </form>
    </main>

    <!-- Incluir el footer -->
    <?php include('footer.php'); ?>

</body>

</html>