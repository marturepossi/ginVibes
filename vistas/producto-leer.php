<?php
$producto = (new Producto)->porId($_GET['id'], true);
?>

    <div class="card container my-5 mt-1 ">
        <div class=" row g-0 bg-light m-3">
            <div class="col-md-12 col-xl-4 pt-4 justify-content-left">
                <figure>
                    <picture>
                    <source srcset="imgs/ta-<?= $producto->getImagen();?>" media="all and (min-width: 46.875em)">
                    <img src="imgs/<?= $producto->getImagen();?>" alt="<?= $producto->getImagenDescripcion();?>" class="img-fluid">
                    </picture>
                </figure>
            </div>
            <div class="col-md-12 col-xl-8 pt-2 p-4 justify-content-left">
                <div class="card-body">
                <?php
                if(count($producto->getEtiquetas()) > 0):
                    foreach($producto->getEtiquetas() as $etiqueta):
                ?>
                    <span class="badge"><?= $etiqueta->getNombre();?></span>
                <?php
                    endforeach;
                endif;
                ?>
                    <h2 class="card-title"><?= $producto->getNombre();?></h2>
                    <p class="card-text"><?= $producto->getDescripcion();?></p>
                    <p class="mt-8 card-text ">$<?= $producto->getPrecio();?>
                    <?php
                    if ($auth->estaAutenticado()): ?>
                        <form action="acciones/agregar-al-carrito.php" method="post">
                            <p>Cantidad:</p>
                            <input type="hidden" name="producto_id" value="<?= $producto->getProductoId(); ?>"> <!-- Cambié $producto['producto_id'] a $producto->getProductoId() -->
                            <input type="number" name="cantidad" value="1" min="1">
                            <button class="mt-3 btn button bg-danger-subtle" type="submit">Agregar al carrito</button>     
                        </form>
                    <?php else: ?>
                    <a href="index.php?seccion=inicio-sesion" class="mt-2 btn button bg-danger-subtle w-100">Comprar</a>
                    <?php endif; ?>
                    <a href="index.php?seccion=productos" class="mt-4">Volver a productos</a>
                    
                </div>
            </div>
        </div> 
    </div>

