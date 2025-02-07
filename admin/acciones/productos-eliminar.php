<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';
session_start();

// Verificamos que el usuario esté autenticado para poder ejecutar esta acción.
$auth = new Autenticacion;
if(!$auth->estaAutenticado()) {
    $_SESSION['feedback-mensaje'] = "No se puede realizar esta acción sin haber iniciado sesión.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: ../index.php?seccion=iniciar-sesion");
    exit;
}

// Capturamos el id de la noticia que quieren eliminar.
// Pese a que a esta acción se entra por un formulario por POST, como estamos mandando la PK en el query string, 
// la tenemos que ir a buscar con $_GET.
$id = $_GET['id'];

try {
    (new Producto)->eliminar($id);

    $_SESSION['feedback-mensaje'] = "El producto se eliminó con éxito.";
    $_SESSION['feedback-tipo'] = "success";

    header("Location: ../index.php?seccion=productos");
    exit;
} catch (\Exception $th) {
    //throw $th;
    $_SESSION['feedback-mensaje'] = "Ocurrió un error inesperado, y el producto no pudo ser eliminada.";
    $_SESSION['feedback-tipo'] = "danger";

    header("Location: ../index.php?seccion=productos");
    exit;
}