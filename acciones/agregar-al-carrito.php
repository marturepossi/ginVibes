<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
session_start();

$autenticacion = new Autenticacion();

if (!$autenticacion->estaAutenticado()) {
    $_SESSION['feedback-mensaje'] = "No estás autenticado. Por favor, inicia sesión.";
    $_SESSION['feedback-tipo'] = "error";
    header('Location: ../index.php?seccion=iniciar-sesion');
    exit;
}

$usuarioId = $autenticacion->getUsuario()->getUsuarioId();
$productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

if ($productoId <= 0 || $cantidad <= 0) {
    $_SESSION['feedback-mensaje'] = "Cantidad no válida.";
    $_SESSION['feedback-tipo'] = "error";
    header('Location: ../index.php?seccion=producto-leer&id=' . $productoId);
    exit;
}

try {
    Carrito::agregarItem($usuarioId, $productoId, $cantidad);
    $_SESSION['feedback-mensaje'] = "Ítem agregado al carrito exitosamente.";
    $_SESSION['feedback-tipo'] = "success";
    header('Location: ../index.php?seccion=producto-leer&id=' . $productoId);
    exit;
} catch (Exception $e) {
    $_SESSION['feedback-mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['feedback-tipo'] = "error";
    header('Location: ../index.php?seccion=producto-leer&id=' . $productoId);
    exit;
}
