<?php

$pedidoId = $_GET['pedido_id'] ?? null;

if (!$pedidoId) {
    $_SESSION['feedback-mensaje'] = "ID del pedido no especificado.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: index.php?seccion=home");
    exit;
}

$pedido = (new Pedido)->porId($pedidoId);
$detalles = (new DetallePedido)->porPedidoId($pedidoId);

if (!$pedido) {
    $_SESSION['feedback-mensaje'] = "Pedido no encontrado.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: index.php?seccion=home");
    exit;
}
?>



        <h1>Detalles del Pedido #<?= $pedido->getPedidoId(); ?></h1>
        <p><strong>Total:</strong> $<?= $pedido->getTotal(); ?></p>
        <p><strong>Fecha:</strong> <?= $pedido->getFecha(); ?></p>

        <h2>Detalles del Pedido</h2>
        <?php if (empty($detalles)): ?>
            <p>No hay detalles para este pedido.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?= $detalle->getNombre(); ?></td>
                            <td><?= $detalle->getCantidad(); ?></td>
                            <td>$<?= $detalle->getPrecio(); ?></td>
                            <td>$<?= $detalle->getCantidad() * $detalle->getPrecio(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
