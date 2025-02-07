<?php

$producto = (new Producto)->porId($_GET['id']);

?>

    <article class="card">
        <div class="noticias-item">
            <div class="noticias-item_content card-body">
                <h1><?= $producto->getNombre();?></h1>
                <p><?= $producto->getDetalle();?></p>
            </div>
            <picture class="noticias-item_imagen">
                <source srcset="imgs/big-<?= $producto->getImagen();?>" media="all and (min-width: 46.875em)">
                <img src="imgs/<?= $producto->getImagen();?>" alt="<?= $producto->getImagenDescripcion();?>">
            </picture>
        </div>

        <div><?= $producto->getDescripcion();?></div>
    </article>

