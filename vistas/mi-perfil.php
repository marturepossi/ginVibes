<?php

$auth = new Autenticacion();

// Si usuario esta autenticado
if (!$auth->estaAutenticado()) {
    echo "No estás autenticado.";
    exit;
}

// Usuario actual
$usuario = $auth->getUsuario();

// Si hay usuarioo
if ($usuario === null) {
    echo "No se pudo encontrar el usuario.";
    exit;
}

//Ultimos pedidos
$ultimosPedidos = (new Pedido)->obtenerPedidosPorUsuario($usuario->getUsuarioId());
?>

<section class="container">
    <section>
        <h2>Datos del Usuario</h2>
        <p>ID: <?= $usuario->getUsuarioId(); ?></p>
        <p>Email: <?= $usuario->getEmail(); ?></p>
        <p>Alias: <?= $usuario->getAlias(); ?></p>
    </section>
    <section>
        <h2>Últimos Pedidos</h2>
        <?php if (empty($ultimosPedidos)): ?>
            <p>No tienes pedidos recientes.</p>
            <a href="index.php?seccion=productos" class="mt-4">Ir a productos</a>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID del Pedido</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Ver pedido</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimosPedidos as $pedido): ?>
                        <tr>
                            <td><?= $pedido->getPedidoId(); ?></td>
                            <td>$<?= $pedido->getTotal(); ?></td>
                            <td><?= $pedido->getFecha(); ?></td>
                            <td>
                                <a href="index.php?seccion=detalle-pedido&pedido_id=<?=$pedido->getPedidoId()?>" class="btn bg-danger-subtle btn-sm">Ver Detalle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
    </section>  



