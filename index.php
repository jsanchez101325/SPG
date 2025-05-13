<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructora Futuro</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Constructora Futuro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios"><i class="fas fa-tools"></i> Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#proyectos"><i class="fas fa-project-diagram"></i> Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#nosotros"><i class="fas fa-users"></i> Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto"><i class="fas fa-envelope"></i> Contacto</a>
                    </li>
                    <?php
                    session_start();
                    if (isset($_SESSION['usuario'])) {
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-user"></i> ' . $_SESSION['usuario'] . '</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                        </li>';
                    } else {
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fas fa-user"></i> Login</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero">
        <div class="slider-background">
            <div class="slider">
                <img src="img/img1.jpg" alt="Imagen 1">
                <img src="img/img2.jpeg" alt="Imagen 2">
                <img src="img/img3.jpg" alt="Imagen 3">
                <img src="img/img4.jpg" alt="Imagen 4">
            </div>
        </div>
        <h1>Construyendo el Futuro Contigo</h1>
    </div>

    <!-- Servicios -->
    <section class="py-5 bg-light" id="servicios">
        <div class="container">
            <h2 class="text-center mb-4">Nuestros Servicios</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card service-card p-3">
                        <h4><i class="fas fa-hard-hat"></i> Construcción de Obras</h4>
                        <p>Proyectos de construcción residencial, comercial e industrial.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card p-3">
                        <h4><i class="fas fa-paint-roller"></i> Remodelaciones</h4>
                        <p>Transformamos espacios para darles nueva vida y funcionalidad.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card p-3">
                        <h4><i class="fas fa-cogs"></i> Supervisión Técnica</h4>
                        <p>Control de calidad y cumplimiento normativo en obra.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proyectos -->
    <section class="py-5" id="proyectos">
        <div class="container">
            <h2 class="text-center mb-4">Proyectos Destacados</h2>
            <div id="proyectosCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/avenida.jpg" class="d-block w-100 carousel-img" alt="Proyecto 1">
                    </div>
                    <div class="carousel-item">
                        <img src="img/puente.jpg" class="d-block w-100 carousel-img" alt="Proyecto 2">
                    </div>
                    <div class="carousel-item">
                        <img src="img/puente1.jpg" class="d-block w-100 carousel-img" alt="Proyecto 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#proyectosCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#proyectosCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Nosotros -->
    <section class="bg-light py-5" id="nosotros">
        <div class="container">
            <h2 class="text-center mb-4">¿Quiénes Somos?</h2>
            <p class="text-center">Somos una empresa comprometida con la excelencia en la construcción. Nuestro equipo
                está compuesto por ingenieros, arquitectos y profesionales apasionados por crear espacios funcionales y
                duraderos.</p>
        </div>
    </section>

    <!-- Contacto -->
    <section class="py-5" id="contacto">
        <div class="container-contacto">
            <h2 class="text-center mb-4">Contáctanos</h2>
            <form class="row g-3" action="enviar_correo.php" method="POST">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Nombre completo" name="nombre" required>
                </div>
                <div class="col-md-6">
                    <input type="email" class="form-control" placeholder="Correo electrónico" name="email" required>
                </div>
                <div class="col-12">
                    <textarea class="form-control" rows="4" placeholder="Mensaje" name="mensaje" required></textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary px-5">Enviar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; 2025 Constructora Futuro | Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>