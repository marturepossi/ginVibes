<?php
require_once __DIR__ . '/bootstrap/autoload.php';
session_start();

$rutas = [
    'home' => [
        'titulo' => 'Nuestros Gins',
    ],
    'productos' => [
        'titulo' => 'Catálogo',
    ],
    'producto-leer' => [
        'titulo' => 'Información del Gin',
    ],
    'contacto' => [
        'titulo' => 'Contacto',
    ],
    'respuesta-mail' => [
        'titulo' => 'Gracias por participar!',
    ],
    '404' => [
        'titulo' => 'Página no Encontrada',
    ],
    'inicio-sesion' => [
        'titulo' => 'Iniciar sesión',
    ],
    'registro' => [
        'titulo' => 'Registrarse',
    ],
    'carrito' => [
        'titulo' => 'Mi carrito',
    ],
    'mi-perfil' => [
        'titulo' => 'Mi perfil',
    ],
    'confirmacion' => [
        'titulo' => 'Gracias por tu compra!',
    ],
    'cerrar-sesion' => [
        'titulo' => 'Cerrar sesión',
    ],
    'detalle-pedido' => [
        'titulo' => 'Detalle del pedido',
    ],
];

$vista = $_GET['seccion'] ?? 'home';

if (!isset($rutas[$vista])) {
    $vista = '404';
}

$rutaConfig = $rutas[$vista];

$auth = new Autenticacion();

// Verificamos si la ruta requiere que el usuario esté autenticado. En caso afirmativo, preguntamos si el usuario lo
// está. De no ser así, lo redireccionamos al login.
$requiereAutenticacion = $rutaConfig['requiereAutenticacion'] ?? false;
if(
    $requiereAutenticacion && 
    (
        !$auth->estaAutenticado() || 
        $auth->getUsuario()->rol_fk != 1 // Si no es admin
    )
) {
    $_SESSION['feedback-mensaje'] = "Para ingresar a esta pantalla se requiere haber iniciado sesión como administrador.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: index.php?seccion=inicio-sesion");
    exit;
}

// Leemos la variable del mensaje de feedback que tenemos en la sesión, si existe, y la borramos.
$feedbackMensaje = $_SESSION['feedback-mensaje'] ?? null;
unset($_SESSION['feedback-mensaje']);
$feedbackTipo = $_SESSION['feedback-tipo'] ?? 'info';
unset($_SESSION['feedback-tipo']);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gin Vibes</title>
    <link rel="icon" href="imgs/icono_barramovil.png" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?seccion=home">
                <img src="imgs/icono_barra.png" alt="Gin Vibes Logo" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?seccion=home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?seccion=productos">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?seccion=contacto">Sorteo</a>
                    </li>

                    <?php if ($auth->estaAutenticado()): ?>
                        <!-- Menú para usuarios autenticados -->
                        <li class="nav-item">
                          <a class="nav-link" href="index.php?seccion=carrito">Mi Carrito</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="index.php?seccion=mi-perfil">Mi Perfil</a>
                        </li>
                        <li class="nav-item">
                          <form action="acciones/logout.php" method="post">
                            <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                          </form>
                        </li>
                    <?php else: ?>
                        <!-- Menú para usuarios no autenticados -->
                        <li class="nav-item"><a class="nav-link" href="index.php?seccion=inicio-sesion">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin/index.php">Administrador</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="main-content container">
    <?php
    require __DIR__ . "/vistas/" . $vista . ".php";
    ?>
</main>

<footer class="bg-danger-subtle">
    <p>Programación II | Final | Martina Repossi | &copy; Da Vinci - 2024</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

