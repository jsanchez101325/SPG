<?php
include('db.php');

// Consulta para obtener los usuarios disponibles
$query_usuarios = "SELECT id, nombre FROM usuarios";
$stmt_usuarios = $pdo->query($query_usuarios);
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_termino = $_POST['fecha_termino'];
    $estado = $_POST['estado'];
    $usuario_id = $_POST['usuario_id'];

    // Inserta el nuevo proyecto en la base de datos
    $query = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_termino, estado, usuario_id) 
              VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_termino, :estado, :usuario_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':fecha_inicio' => $fecha_inicio,
        ':fecha_termino' => $fecha_termino,
        ':estado' => $estado,
        ':usuario_id' => $usuario_id
    ]);

    echo "Proyecto creado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Proyecto</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Incluir Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <!-- Incluir el header -->
    <?php include('header.php'); ?>

    <main>
        <h2><i class="fas fa-project-diagram"></i> Formulario para Crear Proyecto</h2>
        <form action="proyectos.php" method="POST">
            <div>
                <label for="nombre"><i class="fas fa-heading"></i> Nombre del Proyecto</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div>
                <label for="descripcion"><i class="fas fa-pencil-alt"></i> Descripción</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>

            <div>
                <label for="fecha_inicio"><i class="fas fa-calendar-alt"></i> Fecha de Inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>

            <div>
                <label for="fecha_termino"><i class="fas fa-calendar-check"></i> Fecha de Término</label>
                <input type="date" id="fecha_termino" name="fecha_termino" required>
            </div>

            <div>
                <label for="estado"><i class="fas fa-sync-alt"></i> Estado</label>
                <select id="estado" name="estado" required>
                    <option value="En Planificación">En Planificación</option>
                    <option value="Ejecutando">Ejecutando</option>
                    <option value="Terminado">Terminado</option>
                </select>
            </div>

            <div>
                <label for="usuario_id"><i class="fas fa-user-tie"></i> Responsable</label>
                <select id="usuario_id" name="usuario_id" required>
                    <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <button type="submit"><i class="fas fa-plus-circle"></i> Crear Proyecto</button>
            </div>
        </form>
    </main>

    <!-- Incluir el footer -->
    <?php include('footer.php'); ?>

</body>

</html>