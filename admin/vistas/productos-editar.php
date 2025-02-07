<?php
$estadosProducto = (new EstadoProducto)->todos();
$etiquetas = (new Etiqueta)->todas();

// Traemos el objeto de la producto que nos están pidiendo editar.
// Esto lo vamos a necesitar para poder poblar los campos del formulario
$producto = (new Producto)->porId($_GET['id'], true);

// echo "<pre>";
// print_r($producto);
// echo "</pre>";
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);
$dataVieja = $_SESSION['data-vieja'] ?? [];
// $dataVieja = $_SESSION['data-vieja'] ?? ['estado_producto_fk' => null];
unset($_SESSION['data-vieja']);

// Obtenemos los ids de las etiquetas de la producto.
/*
Actualmente tenemos, gracias a que cargamos las relaciones, un array con las etiquetas en el objeto de Noticia.
En ese array, cada etiqueta está como un objeto Etiqueta. Algo así:

    $etiquetasNoticia = $producto->getEtiquetas();
    
Quedaría algo como:

    Array
        (
            [0] => Etiqueta Object
                (
                    [etiqueta_id:protected] => 2
                    [nombre:protected] => Pre-Temporada
                )
            [1] => Etiqueta Object
                (
                    [etiqueta_id:protected] => 8
                    [nombre:protected] => Lesiones
                )
        )

Eso está bien. En general, siempre queremos tener los valores con las clases que los representen, si es que existen.
Pero en este caso particular solo necesitamos el id de la etiqueta.

Así que vamos a hacer un nuevo array con solo esos ids.
*/
// $etiquetasNoticia = [];
// foreach($producto->getEtiquetas() as $etiqueta) {
//     $etiquetasNoticia[] = $etiqueta->getEtiquetaId();
// }

/*
Es un requerimiento muy común tener que transformar un array a otro array.
Es decir, transformar los valores de un array a valores diferentes.
Por ejemplo, como hicimos recién, que transformarmos los objetos Etiqueta a solo sus ids.

Si bien lo podemos resolver como hicimos ahora, con un bucle, también podemos resolverlo con una función: array_map()

array_map() es una función que recibe un callback y un array.
Lo que hace es retornar un nuevo array que se llena con los valores del array original pasados por el callback.

El foreach de recién lo podemos transformar, si lo preferimos, a un array_map de la siguiente forma:
*/
$etiquetasProducto = array_map(function($valor) { 
    return $valor->getEtiquetaId(); 
}, $producto->getEtiquetas());

// echo "<pre>";
// print_r($etiquetasNoticia);
// echo "</pre>";
?>

    <section class="container">
        <h1 class="mb-1">Publicar un nuevo producto</h1>
        <form action="acciones/productos-editar.php?id=<?= $producto->getProductoId();?>" method="post" enctype="multipart/form-data">
            <div class="form-fila">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control"
                    value="<?= ($dataVieja['nombre'] ?? $producto->getNombre());?>"
                    aria-describedby="help-nombre error-nombre"
                >
                <div id="help-nombre" class="form-help">Mínimo 3 caracteres</div>
                <div id="error-nombre">
                <?php
                if(isset($errores['nombre'])):
                ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['nombre'];?></div>
                <?php
                endif;
                ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="detalle">Detalle</label>
                <textarea
                    id="detalle"
                    name="detalle"
                    class="form-control"
                    aria-describedby="error-detalle"
                ><?= $dataVieja['detalle'] ?? $producto->getDetalle();?></textarea>
                <div id="error-detalle">
                <?php
                if(isset($errores['detalle'])):
                ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['detalle'];?></div>
                <?php
                endif;
                ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    aria-describedby="error-descripcion"
                ><?= $dataVieja['descripcion'] ?? $producto->getDescripcion();?></textarea>
                <div id="error-descripcion">
                <?php
                if(isset($errores['descripcion'])):
                ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['descripcion'];?></div>
                <?php
                endif;
                ?>
                </div>
            </div>
            <div class="form-fila">
            <label for="precio">Precio</label>
                <input
                    type="number"
                    id="precio"
                    name="precio"
                    class="form-control"
                    value="<?= ($dataVieja['precio'] ?? $producto->getPrecio());?>"
                    aria-describedby="help-nombre error-precio"
                >
                <div id="help-precio" class="form-help">Mínimo 3 caracteres</div>
                <div id="error-precio">
                <?php
                if(isset($errores['precio'])):
                ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['precio'];?></div>
                <?php
                endif;
                ?>
                </div>
            </div>
            <div class="form-fila">
                <p>Imagen actual</p>
                <?php
                if($producto->getImagen() != null):
                ?>
                <img src="<?= '../imgs/ta-' . $producto->getImagen();?>" alt="">
                <?php
                else:
                ?>
                Sin imagen.
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="imagen">Imagen <span class="small normal">(opcional)</span></label>
                <input type="file" id="imagen" name="imagen" class="form-control" aria-describedby="help-imagen">
                <div class="form-help" id="help-imagen">Solo elegí una imagen si querés cambiar la actual.</div>
            </div>
            <div class="form-fila">
                <label for="imagen_descripcion">Descripción de la Imagen <span class="small normal">(opcional)</span></label>
                <input
                    type="text"
                    id="imagen_descripcion"
                    name="imagen_descripcion"
                    class="form-control"
                    value="<?= $dataVieja['imagen_descripcion'] ?? $producto->getImagenDescripcion();?>"
                >
            </div>
            <div class="form-fila">
                <label for="estado_producto_fk">Estado del Producto</label>
                <select
                    id="estado_producto_fk"
                    name="estado_producto_fk"
                    class="form-control"
                >
                <?php
                foreach($estadosProducto as $estado):
                ?>
                    <option 
                        value="<?= $estado->getEstadoProductoId();?>"
                        <?= $estado->getEstadoProductoId() == ($dataVieja['estado_producto_fk'] ?? $producto->getEstadoProductoFk()) ? "selected" : null;?>
                    >
                        <?= $estado->getNombre();?>
                    </option>
                <?php
                endforeach;
                ?>
                </select>
            </div>

            
            <fieldset class="mb-1">
                <legend>Etiquetas</legend>

                <?php
                foreach($etiquetas as $etiqueta):
                ?>
                <label>
                    <input
                        type="checkbox"
                        name="etiqueta_fk[]"
                        value="<?= $etiqueta->getEtiquetaId();?>"
                        <?= in_array($etiqueta->getEtiquetaId(), $dataVieja['etiqueta_fk'] ?? $etiquetasProducto) ? 
                            'checked' : 
                            null;
                        ?>
                    > 
                    <?= $etiqueta->getNombre();?>
                </label>
                <?php
                endforeach;
                ?>
            </fieldset>
            <button type="submit" class="button">Actualizar</button>
        </form>
    </section>
