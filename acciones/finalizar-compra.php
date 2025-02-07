<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
session_start(); 

$autenticacion = new Autenticacion();
if (!$autenticacion->estaAutenticado()) {
    die('No estás autenticado. Por favor, inicia sesión.');
}

// ID del usuario autent
$usuarioId = $autenticacion->getUsuario()->getUsuarioId();

try {
    $db = (new Conexion)->obtenerConexion();

    $itemsCarrito = Carrito::cargarCarrito($usuarioId);

    if (empty($itemsCarrito)) {
        die('No hay productos en el carrito.');
    }

    $total = 0;
    foreach ($itemsCarrito as $item) {
        $total += $item['cantidad_total'] * $item['producto_precio'];
    }

    $consultaPedido = "INSERT INTO pedidos (usuario_fk, total) VALUES (?, ?)";
    $stmtPedido = $db->prepare($consultaPedido);
    $stmtPedido->execute([$usuarioId, $total]);
    $pedidoId = $db->lastInsertId(); 
   
    $consultaDetalles = "INSERT INTO pedido_detalles (pedido_fk, producto_fk, nombre, cantidad, precio) VALUES (?, ?, ?, ?, ?)";
    $stmtDetalles = $db->prepare($consultaDetalles);

    foreach ($itemsCarrito as $item) {
        $stmtDetalles->execute([
            $pedidoId,
            $item['producto_fk'],
            $item['producto_nombre'],
            $item['cantidad_total'],
            $item['producto_precio']
        ]);
    }

    $consultaVaciarCarrito = "DELETE FROM carrito WHERE usuario_fk = ?";
    $stmtVaciarCarrito = $db->prepare($consultaVaciarCarrito);
    $stmtVaciarCarrito->execute([$usuarioId]);

    header('Location: ../index.php?seccion=confirmacion');
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

