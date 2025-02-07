<?php

$productos = (new Producto)->todasV2();

?>

    <section class="container">
        <h1 class="mb-1">Administración de Producto</h1>

        <div class="mb-1"><a href="index.php?seccion=productos-nuevo">Publicar un nuevo Producto</a></div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estado del Producto</th>
                    <th>Fecha de Publicación</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Etiquetas</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($productos as $producto):
                ?>
                <tr>
                    <td><?= $producto->getProductoId();?></td>
                    <?php?>
                    <td><?= $producto->getEstadoProducto()->getNombre();?></td>
                    <td><?= $producto->getFechaPublicacion();?></td>
                    <td><?= $producto->getNombre();?></td>
                    <td><?= $producto->getDetalle();?></td>
                    <td><?= $producto->getDescripcion();?></td>
                    <td><?= $producto->getPrecio();?></td>
                    <td>
                        <?php 
                        if(count($producto->getEtiquetas()) > 0):
                            foreach($producto->getEtiquetas() as $etiqueta):
                        ?>
                            <span class="badge"><?= $etiqueta->getNombre();?></span>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <i>Sin etiquetas</i>
                        <?php
                        endif;
                        ?>
                    </td>
                    <td><img src="<?= '../imgs/' . $producto->getImagen();?>" alt=""></td>
                    <td>
                        <div class="">
                            <a href="index.php?seccion=productos-editar&id=<?= $producto->getProductoId();?>" class="mb-3 button">Editar</a>
                            <a href="index.php?seccion=productos-eliminar&id=<?= $producto->getproductoId();?>" class="mb-3 button">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
        
    </section>

