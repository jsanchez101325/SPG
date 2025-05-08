<?php
include('db.php');

// Consulta para obtener los proyectos disponibles
$query_proyectos = "SELECT id, nombre FROM proyectos";
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
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

    echo "Recurso creado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Recurso</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <h1>🔨 Crear Recurso - Constructora SPG</h1>
    </header>

    <nav>
        <a href="index.php">🏠 Inicio</a>
        <a href="proyectos.php">📊 Proyectos</a>
        <a href="presupuesto.php">📊 Presupuesto</a>
        <a href="recursos.php">🔨 Recursos</a>
    </nav>

    <main>
        <h2>Formulario para Crear Recurso</h2>
        <form action="recursos.php" method="POST">
            <div>
                <label for="proyecto_id">Proyecto</label>
                <select id="proyecto_id" name="proyecto_id" required>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <option value="<?php echo $proyecto['id']; ?>"><?php echo htmlspecialchars($proyecto['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nombre" class="form-label">Nombre del Recurso</label>
                <input type="text" id="nombre" name="nombre" class="form-input" required>
            </div>


            <div>
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" required>
            </div>

            <div>
                <label for="costo">Costo</label>
                <input type="number" id="costo" name="costo" step="0.01" required>
            </div>

            <div>
                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" required>
            </div>

            <div>
                <button type="submit">Crear Recurso</button>
            </div>
        </form>
    </main>

</body>

</html>