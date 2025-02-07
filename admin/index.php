<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
// require_once __DIR__ . '/../clases/Autenticacion.php';
session_start(); // Iniciamos la sesión para tener acceso a las variables de sesión en $_SESSION.

// Administración.
// Para el admin, estamos generando una copia de la estructura básica de la web:
// - El index.php.
// - La carpeta views.
// - La carpeta acciones.
// El resto de los archivos los vamos a compartir con los del sitio "común".
$rutas = [
    'iniciar-sesion' => [
        'titulo' => 'Ingresar al Panel',
    ],
    'dashboard' => [
        'titulo' => 'Tablero',
        'requiereAutenticacion' => true,
    ],
    'productos' => [
        'titulo' => 'Administración de Productos',
        'requiereAutenticacion' => true,
    ],
    'productos-nuevo' => [
        'titulo' => 'Publicar una nuevo producto',
        'requiereAutenticacion' => true,
    ],
    'productos-editar' => [
        'titulo' => 'Editar un producto',
        'requiereAutenticacion' => true,
    ],
    'productos-eliminar' => [
        'titulo' => 'Eliminar un producto',
        'requiereAutenticacion' => true,
    ],
    'producto-leer' => [
        'titulo' => 'Detalle del producto',
        'requiereAutenticacion' => true,
    ],
    '404' => [
        'titulo' => 'Página no Encontrada',
    ],
    'usuarios' => [
        'titulo' => 'Usuarios Registrados',
    ],
    'pedidos-usuario' => [
        'titulo' => 'Pedidos del usuario',
    ],
];

$vista = $_GET['seccion'] ?? 'dashboard';

// Verificamos si la vista que nos están pidiendo se permite.
if(!isset($rutas[$vista])) {
    $vista = '404';
}

// Obtenemos las opciones/configuración de la ruta que corresponden a esta vista.
$rutaConfig = $rutas[$vista];

// Manejo de la autenticación.
$auth = new Autenticacion;

// Verificamos si la ruta requiere que el usuario esté autenticado. En caso afirmativo, preguntamos si el usuario lo
// está. De no ser así, lo redireccionamos al login.
$requiereAutenticacion = $rutaConfig['requiereAutenticacion'] ?? false;
if(
    $requiereAutenticacion && 
    (
        !$auth->estaAutenticado() || 
        $auth->getUsuario()->getRolFk() != 1 // Si no es admin
    )
) {
    $_SESSION['feedback-mensaje'] = "Para ingresar a esta pantalla se requiere haber iniciado sesión como administrador.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: index.php?seccion=iniciar-sesion");
    exit;
}

// Leemos la variable del mensaje de feedback que tenemos en la sesión, si existe, y la borramos.
$feedbackMensaje = $_SESSION['feedback-mensaje'] ?? null;
unset($_SESSION['feedback-mensaje']);
$feedbackTipo = $_SESSION['feedback-tipo'] ?? 'info';
unset($_SESSION['feedback-tipo']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gin Vibes</title>
    <link rel="icon" href="../imgs/icono_barramovil.png" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
  </head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?seccion=dashboard">
                    <img src="../imgs/icono_barra.png" alt="Gin Vibes Logo" width="100">
                </a>
                <p>Panel de Administración</p>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <?php if ($auth->estaAutenticado()): ?>  
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php?seccion=dashboard">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php?seccion=productos">Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php?seccion=usuarios">Mis Usuarios</a>
                            </li>
                            <li>
                                <form action="acciones/logout.php" method="post">
                                    <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="main-content container">
        <?php
        // Agregamos el mensaje de feedback, si es que hay uno.
        // TODO: Ver cómo protegernos de "inyección de HTML" para prevenir ataques de XSS.
        if($feedbackMensaje !== null):
        ?>
            <div class="<?= 'msg-' . $feedbackTipo;?>">
                <?= $feedbackMensaje;?>
            </div>
        <?php
        endif;
        ?>

        <?php
        // __DIR__ es una "constante mágica" de php.
        // Esta constante retorna la ruta absoluta a la carpeta del archivo en el que estoy.
        // Cuando hacemos requires o includes, siempre es una buena idea usar __DIR__ para la
        // ruta.
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
