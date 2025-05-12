<?php
include('db.php');

// Consultar los proyectos desde la tabla 'proyectos'
$query_proyectos = "SELECT * FROM proyectos";  
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);

// Consultar los recursos desde la tabla 'recursos'
$query_recursos = "SELECT * FROM recursos";  
$stmt_recursos = $pdo->query($query_recursos);
$recursos = $stmt_recursos->fetchAll(PDO::FETCH_ASSOC);

// Consultar el presupuesto desde la tabla 'presupuesto' con el nombre del proyecto
$query_presupuesto = "
    SELECT 
        pr.proyecto_id, 
        pr.monto, 
        p.nombre AS nombre_proyecto
    FROM presupuesto pr
    LEFT JOIN proyectos p ON pr.proyecto_id = p.id
";  
$stmt_presupuesto = $pdo->query($query_presupuesto);
$presupuesto = $stmt_presupuesto->fetchAll(PDO::FETCH_ASSOC);

// Consultar los mensajes de comunicación desde la tabla 'comunicacion'
$query_comunicacion = "SELECT * FROM comunicacion";  
$stmt_comunicacion = $pdo->query($query_comunicacion);
$comunicacion = $stmt_comunicacion->fetchAll(PDO::FETCH_ASSOC);

// Consultar los usuarios desde la tabla 'usuarios'
$query_usuarios = "SELECT * FROM usuarios";  
$stmt_usuarios = $pdo->query($query_usuarios);
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Consultar el estado general de los proyectos
$query_estado_general = "
    SELECT 
        p.nombre AS proyecto, 
        p.descripcion AS descripcion_proyecto,
        pr.monto AS presupuesto, 
        r.nombre AS recurso, 
        r.cantidad, 
        r.costo,
        u.nombre AS usuario_responsable
    FROM proyectos p
    LEFT JOIN presupuesto pr ON p.id = pr.proyecto_id
    LEFT JOIN recursos r ON p.id = r.proyecto_id
    LEFT JOIN usuarios u ON p.usuario_id = u.id
";
$stmt_estado_general = $pdo->query($query_estado_general);
$estado_general = $stmt_estado_general->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario para enviar mensaje o comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proyecto_id = $_POST['proyecto_id'];
    $mensaje = $_POST['mensaje'];
    $usuario_id = $_POST['usuario_id'];

    // Insertar el mensaje en la base de datos
    $query_insert = "INSERT INTO comunicacion (proyecto_id, mensaje, usuario_id, fecha) 
                     VALUES (:proyecto_id, :mensaje, :usuario_id, NOW())";
    $stmt_insert = $pdo->prepare($query_insert);
    $stmt_insert->execute([
        'proyecto_id' => $proyecto_id,
        'mensaje' => $mensaje,
        'usuario_id' => $usuario_id
    ]);

    // Redirigir para evitar el reenvío del formulario al actualizar
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Programa de Estado - Constructora SPG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Incluir el encabezado -->
    <?php include('header.php'); ?>

    <main>
        <br></br>

        <h2>📋 Resumen Ejecutivo</h2>
        <p>El avance del proyecto se desarrolla según el cronograma establecido, con todas las actividades y tareas
            siendo gestionadas de manera eficiente.</p>

        <h2>📌 Estado General del Proyecto</h2>
        <table>
            <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Descripción</th>
                    <th>Presupuesto</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($estado_general)): ?>
                <?php foreach ($estado_general as $proyecto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($proyecto['proyecto']); ?></td>
                    <td><?php echo htmlspecialchars($proyecto['descripcion_proyecto']); ?></td>
                    <td>$<?php echo htmlspecialchars($proyecto['presupuesto']); ?></td>
                    <td><?php echo htmlspecialchars($proyecto['usuario_responsable']); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron proyectos.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>📊 Recursos Disponibles</h2>
        <ul>
            <?php foreach ($recursos as $recurso): ?>
            <li><?php echo htmlspecialchars($recurso['nombre']); ?> -
                <?php echo htmlspecialchars($recurso['cantidad']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>📈 Presupuesto Asignado</h2>
        <ul>
            <?php foreach ($presupuesto as $item): ?>
            <li><?php echo htmlspecialchars($item['nombre_proyecto']); ?>:
                $<?php echo htmlspecialchars($item['monto']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>💬 Mensajes y Comentarios</h2>
        <ul>
            <?php foreach ($comunicacion as $mensaje): ?>
            <li><strong><?php echo htmlspecialchars($mensaje['fecha']); ?>:</strong>
                <?php echo htmlspecialchars($mensaje['mensaje']); ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Formulario para enviar mensaje o comentario sobre un proyecto -->
        <h2>📨 Enviar Comentario o Mensaje</h2>
        <form action="index.php" method="POST">
            <div>
                <label for="proyecto_id">Seleccionar Proyecto</label>
                <select id="proyecto_id" name="proyecto_id" required>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <option value="<?php echo $proyecto['id']; ?>"><?php echo htmlspecialchars($proyecto['nombre']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="mensaje">Comentario o Mensaje</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
            </div>

            <div>
                <label for="usuario_id">Seleccionar Usuario</label>
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

    <!-- Incluir el pie de página -->
    <?php include('footer.php'); ?>

</body>

</html>