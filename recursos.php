<?php
include('db.php');

// Consulta para obtener los proyectos disponibles
$query_proyectos = "SELECT id, nombre FROM proyectos";
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proyecto_id = $_POST['proyecto_id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];

    // Inserta el nuevo recurso en la base de datos
    $query = "INSERT INTO recursos (proyecto_id, nombre, cantidad, costo, fecha_adquisicion) 
              VALUES (:proyecto_id, :nombre, :cantidad, :costo, :fecha_adquisicion)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':proyecto_id' => $proyecto_id,
        ':nombre' => $nombre,
        ':cantidad' => $cantidad,
        ':costo' => $costo,
        ':fecha_adquisicion' => $fecha_adquisicion
    ]);

    $mensaje = "✅ Recurso creado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Recursos</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Incluir Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="contenedor">
        <h2><i class="fas fa-toolbox"></i> Formulario para Crear Recurso</h2>

        <?php if (!empty($mensaje)) : ?>
        <div class="mensaje-exito"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form action="recursos.php" method="POST" class="formulario">
            <div class="form-group">
                <label for="proyecto_id" class="form-label"><i class="fas fa-diagram-project"></i> Proyecto</label>
                <select id="proyecto_id" name="proyecto_id" class="form-input" required>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <option value="<?php echo $proyecto['id']; ?>">
                        <?php echo htmlspecialchars($proyecto['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nombre" class="form-label"><i class="fas fa-box-open"></i> Nombre del Recurso</label>
                <input type="text" id="nombre" name="nombre" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="cantidad" class="form-label"><i class="fas fa-sort-numeric-up"></i> Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="costo" class="form-label"><i class="fas fa-dollar-sign"></i> Costo</label>
                <input type="number" id="costo" name="costo" step="0.01" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="fecha_adquisicion" class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de
                    Adquisición</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" class="form-input" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Crear Recurso</button>
            </div>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>