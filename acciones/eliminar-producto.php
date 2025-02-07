<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
session_start();

$autenticacion = new Autenticacion();
if (!$autenticacion->estaAutenticado()) {
    die('No estás autenticado. Por favor, inicia sesión.');
}

$usuarioId = $autenticacion->getUsuario()->getUsuarioId();
$productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
$cantidadAReducir = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

// Producto ID y la cantidad son vlaidos
if ($productoId <= 0 || $cantidadAReducir <= 0) {
    $_SESSION['feedback-mensaje'] = "Datos del producto o cantidad no válidos.";
    $_SESSION['feedback-tipo'] = "error";
    header('Location: ../index.php?seccion=carrito');
    exit;
}

try {
    $db = (new Conexion)->obtenerConexion();

    // Cantidad actual del producto en el carrito
    $consultaCantidadActual = "SELECT cantidad FROM carrito WHERE usuario_fk = ? AND producto_fk = ?";
    $stmtCantidad = $db->prepare($consultaCantidadActual);
    $stmtCantidad->execute([$usuarioId, $productoId]);
    $cantidadActual = $stmtCantidad->fetchColumn();

    if ($cantidadActual === false) {
        $_SESSION['feedback-mensaje'] = "El producto no está en el carrito.";
        $_SESSION['feedback-tipo'] = "error";
    } else {
        if ($cantidadActual <= $cantidadAReducir) {
            // Elimina
            $consultaEliminar = "DELETE FROM carrito WHERE usuario_fk = ? AND producto_fk = ?";
            $stmtEliminar = $db->prepare($consultaEliminar);
            $stmtEliminar->execute([$usuarioId, $productoId]);
            $_SESSION['feedback-mensaje'] = "Producto eliminado del carrito.";
        } else {
            // Reduce
            $consultaActualizar = "UPDATE carrito SET cantidad = cantidad - ? WHERE usuario_fk = ? AND producto_fk = ?";
            $stmtActualizar = $db->prepare($consultaActualizar);
            $stmtActualizar->execute([$cantidadAReducir, $usuarioId, $productoId]);
            $_SESSION['feedback-mensaje'] = "Cantidad reducida en el carrito.";
        }
        $_SESSION['feedback-tipo'] = "success";
    }
} catch (Exception $e) {
    $_SESSION['feedback-mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['feedback-tipo'] = "error";
}

header('Location: ../index.php?seccion=carrito');
exit;
