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

// Consultar la comunicación desde la tabla 'comunicacion'
$query_comunicacion = "SELECT * FROM comunicacion";  
$stmt_comunicacion = $pdo->query($query_comunicacion);
$comunicacion = $stmt_comunicacion->fetchAll(PDO::FETCH_ASSOC);

// Consultar el estado general de los proyectos
$query_estado_general = "
    SELECT 
        p.nombre AS proyecto, 
        p.descripcion AS descripcion_proyecto,
        pr.monto AS presupuesto, 
        c.mensaje AS comunicacion, 
        r.nombre AS recurso, 
        r.cantidad, 
        r.costo,
        u.nombre AS usuario_responsable
    FROM proyectos p
    LEFT JOIN presupuesto pr ON p.id = pr.proyecto_id
    LEFT JOIN comunicacion c ON p.id = c.proyecto_id
    LEFT JOIN recursos r ON p.id = r.proyecto_id
    LEFT JOIN usuarios u ON p.usuario_id = u.id
";
$stmt_estado_general = $pdo->query($query_estado_general);
$estado_general = $stmt_estado_general->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Programa de Status - Constructora SPG</title>
    <link rel="stylesheet" href="css/style.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Incluir el header -->
    <?php include('header.php'); ?>

    <main>
        <br></br>

        <h2>📋 Resumen Ejecutivo</h2>
        <p>El proyecto avanza conforme al cronograma establecido...</p>

        <h2>📌 Estado General del Proyecto</h2>
        <table>
            <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Descripción</th>
                    <th>Presupuesto</th>
                    <th>Recursos</th>
                    <th>Comunicaciones</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estado_general as $proyecto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($proyecto['proyecto']); ?></td>
                    <td><?php echo htmlspecialchars($proyecto['descripcion_proyecto']); ?></td>
                    <td>$<?php echo htmlspecialchars($proyecto['presupuesto']); ?></td>
                    <td><?php echo htmlspecialchars($proyecto['recurso']); ?>
                        (<?php echo htmlspecialchars($proyecto['cantidad']); ?>)</td>
                    <td><?php echo htmlspecialchars($proyecto['comunicacion']); ?></td>
                    <td><?php echo htmlspecialchars($proyecto['usuario_responsable']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>📊 Recursos Disponibles</h2>
        <ul>
            <?php foreach ($recursos as $recurso): ?>
            <li><?php echo htmlspecialchars($recurso['nombre']); ?> -
                <?php echo htmlspecialchars($recurso['cantidad']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>📈 Presupuesto</h2>
        <ul>
            <?php foreach ($presupuesto as $item): ?>
            <li><?php echo htmlspecialchars($item['nombre_proyecto']); ?>:
                $<?php echo htmlspecialchars($item['monto']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>💬 Comunicaciones</h2>
        <ul>
            <?php foreach ($comunicacion as $mensaje): ?>
            <li><strong><?php echo htmlspecialchars($mensaje['fecha']); ?>:</strong>
                <?php echo htmlspecialchars($mensaje['mensaje']); ?></li>
            <?php endforeach; ?>
        </ul>
    </main>

    <!-- Incluir el footer -->
    <?php include('footer.php'); ?>

</body>

</html>