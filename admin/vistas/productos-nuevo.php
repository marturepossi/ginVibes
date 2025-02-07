<?php
// Recuperar los estados del producto y las etiquetas para poblar el formulario
$estadosProducto = (new EstadoProducto)->todos();
$etiquetas = (new Etiqueta)->todas();

// Recuperar y limpiar los errores y los datos viejos de la sesión
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);
$dataVieja = $_SESSION['data-vieja'] ?? [];
unset($_SESSION['data-vieja']);
?>


    <section class="container">
        <h1 class="mb-1">Publicar un nuevo producto</h1>
        <form action="acciones/productos-grabar.php" method="post" enctype="multipart/form-data">
            <div class="form-fila">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control"
                    value="<?= $dataVieja['nombre'] ?? ''; ?>"
                    aria-describedby="help-nombre error-nombre"
                >
                <div id="help-nombre" class="form-help">Mínimo 3 caracteres</div>
                <div id="error-nombre">
                <?php if(isset($errores['nombre'])): ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['nombre']; ?></div>
                <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="detalle">Detalle</label>
                <textarea
                    id="detalle"
                    name="detalle"
                    class="form-control"
                    aria-describedby="error-detalle"
                ><?= $dataVieja['detalle'] ?? ''; ?></textarea>
                <div id="error-detalle">
                <?php if(isset($errores['detalle'])): ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['detalle']; ?></div>
                <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    aria-describedby="error-descripcion"
                ><?= $dataVieja['descripcion'] ?? ''; ?></textarea>
                <div id="error-descripcion">
                <?php if(isset($errores['descripcion'])): ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['descripcion']; ?></div>
                <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="precio">Precio</label>
                <input
                    type="text"
                    id="precio"
                    name="precio"
                    class="form-control"
                    value="<?= $dataVieja['precio'] ?? ''; ?>"
                    aria-describedby="error-precio"
                >
                <div id="error-precio">
                <?php if(isset($errores['precio'])): ?>
                    <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['precio']; ?></div>
                <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="imagen">Imagen <span class="small normal">(opcional)</span></label>
                <input type="file" id="imagen" name="imagen" class="form-control">
            </div>
            <div class="form-fila">
                <label for="imagen_descripcion">Descripción de la Imagen <span class="small normal">(opcional)</span></label>
                <input
                    type="text"
                    id="imagen_descripcion"
                    name="imagen_descripcion"
                    class="form-control"
                    value="<?= $dataVieja['imagen_descripcion'] ?? ''; ?>"
                >
            </div>
            <div class="form-fila">
                <label for="estado_producto_fk">Estado del producto</label>
                <select
                    id="estado_producto_fk"
                    name="estado_producto_fk"
                    class="form-control"
                >
                <?php foreach($estadosProducto as $estado): ?>
                    <option 
                        value="<?= $estado->getEstadoProductoId(); ?>"
                        <?= $estado->getEstadoProductoId() == ($dataVieja['estado_producto_fk'] ?? null) ? "selected" : ''; ?>
                    >
                        <?= $estado->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>

            <fieldset class="mb-1">
                <legend>Etiquetas</legend>
                <?php foreach($etiquetas as $etiqueta): ?>
                <label>
                    <input
                        type="checkbox"
                        name="etiqueta_fk[]"
                        value="<?= $etiqueta->getEtiquetaId(); ?>"
                        <?= in_array($etiqueta->getEtiquetaId(), $dataVieja['etiqueta_fk'] ?? []) ? 'checked' : ''; ?>
                    > 
                    <?= $etiqueta->getNombre(); ?>
                </label>
                <?php endforeach; ?>
            </fieldset>
            <button type="submit" class="button">Publicar</button>
        </form>
    </section>

