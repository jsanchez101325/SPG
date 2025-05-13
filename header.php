<?php session_start(); ?>

<!-- Encabezado principal -->
<header>
    <h1><i class="fas fa-hard-hat"></i> Programa de Status - Constructora SPG</h1>

    <?php if (!isset($_SESSION['usuario_id'])): ?>
    <h3>
        <a href="logout.php" style="color: #2563eb; text-decoration: none;">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </h3>
    <?php else: ?>

    <?php endif; ?>
</header>

<!-- Barra de navegación -->
<nav>
    <a href="index.php"><i class="fas fa-home"></i> Inicio</a>
    <a href="proyectos.php"><i class="fas fa-clipboard-list"></i> Proyecto</a>
    <a href="presupuesto.php"><i class="fa-solid fa-file-invoice-dollar"></i> Presupuesto</a>
    <a href="recursos.php"><i class="fa-solid fa-screwdriver-wrench"></i> Recursos</a>
    <a href="sobre.php"><i class="fas fa-info-circle"></i> Sobre el Proyecto</a>
</nav>