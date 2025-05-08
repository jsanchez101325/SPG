<?php
include('db.php');

// Consulta para obtener los proyectos disponibles
$query_proyectos = "SELECT id, nombre FROM proyectos";
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proyecto_id = $_POST['proyecto_id'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Inserta el nuevo presupuesto en la base de datos
    $query = "INSERT INTO presupuesto (proyecto_id, monto, fecha, descripcion) 
              VALUES (:proyecto_id, :monto, :fecha, :descripcion)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':proyecto_id' => $proyecto_id,
        ':monto' => $monto,
        ':fecha' => $fecha,
        ':descripcion' => $descripcion
    ]);

    echo "Presupuesto creado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Presupuesto</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <h1>💰 Crear Presupuesto - Constructora SPG</h1>
    </header>

    <nav>
        <a href="index.php">🏠 Inicio</a>
        <a href="proyectos.php">📊 Proyectos</a>
        <a href="presupuesto.php">📊 Presupuesto</a>
    </nav>

    <main>
        <h2>Formulario para Crear Presupuesto</h2>
        <form action="presupuesto.php" method="POST">
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
                <label for="monto">Monto</label>
                <input type="number" id="monto" name="monto" step="0.01" required>
            </div>

            <div>
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div>
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>

            <div>
                <button type="submit">Crear Presupuesto</button>
            </div>
        </form>
    </main>

</body>

</html>