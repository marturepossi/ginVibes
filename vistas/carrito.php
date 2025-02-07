<?php

$autenticacion = new Autenticacion();

if (!$autenticacion->estaAutenticado()) {
    die('No estás autenticado. Por favor, inicia sesión.');
}

// ID del usuario autent
$usuarioId = $autenticacion->getUsuario()->getUsuarioId();

// Carga items del carrito
$itemsCarrito = Carrito::cargarCarrito($usuarioId);

$totalCarrito = 0;
?>

    <section class="container">
        <h1 class="mb-1">Contenido de tu Carrito</h1>

        <?php if (empty($itemsCarrito)): ?>
            <p>Tu carrito está vacío.</p>
            <a href="index.php?seccion=productos" class="mt-4">Ir a productos</a>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itemsCarrito as $item): ?>
                        <?php
                        $totalItem = $item['cantidad_total'] * $item['producto_precio'];
                        $totalCarrito += $totalItem;
                        ?>
                        <tr>
                            <td><?= $item['producto_fk']; ?></td>
                            <td><?= $item['producto_nombre']; ?></td>
                            <td><?= $item['cantidad_total']; ?></td>
                            <td><?= $item['producto_precio']; ?></td>
                            <td><?= $totalItem; ?></td>
                            <td>
                            <form action="acciones/eliminar-producto.php" method="post" style="display:inline;">
                                    <input type="hidden" name="producto_id" value="<?= $item['producto_fk']; ?>">
                                    <input type="hidden" name="cantidad" value="1"> <!-- Cantidad a reducir -->
                                    <button type="submit" class="btn bg-danger-subtle">Eliminar</button>
                                </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-carrito">
                <h2>Total del Carrito: <?= $totalCarrito; ?></h2>
            </div>
            <form action="acciones/finalizar-compra.php" method="post">
                <button type="submit" class="button bg-danger-subtle">Finalizar compra</button>
            </form>

        <?php endif; ?>
    </section>

