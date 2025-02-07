<?php



// Obtiene el ID del usuario desde la solicitud (GET o POST)
$usuarioId = $_GET['usuario_id'] ?? 0;

if ($usuarioId) {
    // Crea una instancia de la clase Pedido
    $pedido = new Pedido();
    
    // Obtiene los pedidos del usuario
    $pedidos = $pedido->obtenerPedidosPorUsuario($usuarioId);
} else {
    $pedidos = [];
}

// Aquí puedes incluir el HTML para mostrar los pedidos, por ejemplo:
?>

<section class="container">
    <h1 class="mb-1">Administración de Producto</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido->getPedidoId();?></td>
                    <td>$<?= $pedido->getTotal();?></td>
                    <td><?= $pedido->getFecha();?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

