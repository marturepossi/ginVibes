<?php

$producto = (new Producto)->porId($_GET['id']);

?>

<section class="container">
    <h1 class="mb-3">Confirmación Requerida</h1>
    <p class="mb-3">Estás a punto de eliminar de manera permanente este registro.</p>
    <article class="">
        <div class="productos-card">
            <div class="productos-card_content card-body">
                <h2><?= $producto->getNombre();?></h1>
                <p><?= $producto->getDetalle();?></p>
                <p>Precio: <?= $producto->getPrecio();?></p>

            </div>
        </div>
        <hr class="mb-3">
        <h2 class="mb-3">Confirmar para eliminar el producto.</h2>
        <form action="acciones/productos-eliminar.php?id=<?= $producto->getProductoId();?>" method="post">
            <button type="submit" class="button button-eliminar">Eliminar</button>
        </form>
    </article>
</section>
