<!-- header.php -->
<?php session_start(); ?>

<header>
    <h1>🏗️ Programa de Status - Constructora SPG</h1>
    <?php if (!isset($_SESSION['usuario_id'])): ?>
    <!-- Si el usuario no está logueado, mostrar opción para iniciar sesión -->
    <h3><a href="login.php">🔐 Iniciar sesión</a></h3>
    <?php else: ?>
    <!-- Si el usuario está logueado, mostrar su nombre y opción para cerrar sesión -->
    <h3>👤 Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> |
        <a href="logout.php">Cerrar sesión</a>
    </h3>
    <?php endif; ?>
</header>

<nav>
    <a href="index.php"><i class="fas fa-home"></i> Inicio</a>
    <a href="proyectos.php"><i class="fas fa-clipboard-list"></i> Proyecto</a>
    <a href="presupuesto.php"><i class="fa-solid fa-file-invoice-dollar"></i> Presupuesto</a>
    <a href="recursos.php"><i class="fa-solid fa-screwdriver-wrench"></i> Recursos</a>
    <a href="sobre.html"><i class="fas fa-info-circle"></i> Sobre el Proyecto</a>
</nav>