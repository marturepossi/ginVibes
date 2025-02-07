<?php
$productos = (new Producto)->todasV2();
$total_productos = count($productos);

?>

    <section class="container-fluid my-5">
        <div>
            <h1 class="text-center">Nuestros Productos</h1>
        </div>
        <div class="row">
            <?php 
            for ($i = 0; $i < $total_productos; $i += 2): ?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <img src="imgs/ta-<?= $productos[$i]->getImagen();?>" class="card-img-top" alt="<?= $productos[$i]->getImagenDescripcion();?>">
                        <div class="card-body">
                            <h2 class="card-title"><?= $productos[$i]->getNombre();?></h2>
                            <p class="card-text"><?= $productos[$i]->getDetalle();?></p>
                            <p class="card-subtitle mb-2"> $<?= $productos[$i]->getPrecio();?></p>
                            <a href="index.php?seccion=producto-leer&id=<?= $productos[$i]->getProductoId();?>" class="btn button bg-danger-subtle ">Saber más</a>
                        </div>
                    </div>
                </div>
                <?php if ($i + 1 < $total_productos): ?>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <img src="imgs/ta-<?= $productos[$i + 1]->getImagen();?>" class="card-img-top" alt="<?= $productos[$i + 1]->getImagenDescripcion();?>">
                            <div class="card-body">
                                <h2 class="card-title"><?= $productos[$i + 1]->getNombre();?></h2>
                                <p class="card-text"><?= $productos[$i + 1]->getDetalle();?></p>
                                <p class="card-subtitle mb-2"> $ <?= $productos[$i + 1]->getPrecio();?></p>
                                <a href="index.php?seccion=producto-leer&id=<?= $productos[$i + 1]->getProductoId();?>" class="btn button bg-danger-subtle">Saber más</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </section>
