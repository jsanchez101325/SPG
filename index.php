<?php
include('db.php');

// Consultar el estado del proyecto desde la base de datos 'spg'
$query_fases = "SELECT * FROM fases_proyecto";  
$stmt_fases = $pdo->query($query_fases);
$fases = $stmt_fases->fetchAll(PDO::FETCH_ASSOC);

// Consultar los proyectos desde la base de datos 'spg'
$query_proyectos = "SELECT * FROM proyectos";  
$stmt_proyectos = $pdo->query($query_proyectos);
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Programa de Status - Constructora SPG</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <header>
        <h1>🏗️ Programa de Status - Constructora SPG</h1>
    </header>

    <nav>
        <a href="index.php">🏠 Inicio</a>
        <a href="proyectos.php">📊 Status del Proyecto</a>
        <a href="presupuesto.php">📊 Presupuesto</a>
        <a href="comunicacion.php">📊 Comunicación</a>
        <a href="sobre.html">ℹ️ Sobre el Proyecto</a>
    </nav>

    <main>
        <p><strong>Fecha del reporte:</strong> 07/05/2025</p>
        <p><strong>Responsable:</strong> Ing. Jose Sánchez</p>
        <p><strong>Proyecto:</strong> J&J - Proyecto “Santiago”</p>
        <p><strong>Ubicación:</strong> Santiago de los Caballeros</p>

        <h2>📋 Resumen Ejecutivo</h2>
        <p>El proyecto avanza conforme al cronograma establecido...</p>

        <h2>📌 Estado General del Proyecto</h2>
        <table>
            <thead>
                <tr>
                    <th>Fase</th>
                    <th>Estado</th>
                    <th>% Avance</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fases as $fase): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fase['nombre_fase']); ?></td>
                    <td class="<?php echo htmlspecialchars($fase['estado']); ?>">
                        <?php echo htmlspecialchars($fase['estado']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($fase['avance']); ?>%</td>
                    <td><?php echo htmlspecialchars($fase['observaciones']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>📊 Proyectos Disponibles</h2>
        <ul>
            <?php foreach ($proyectos as $proyecto): ?>
            <li>
                <a href="<?php echo htmlspecialchars($proyecto['url']); ?>" target="_blank">
                    <?php echo htmlspecialchars($proyecto['nombre']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <!-- Resto del contenido, puedes agregar más consultas aquí para obtener más datos -->

    </main>

</body>

</html>