<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';
session_start(); 

$auth = new Autenticacion;
if(!$auth->estaAutenticado()) {
    $_SESSION['feedback-mensaje'] = "No se puede realizar esta acción sin haber iniciado sesión.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: ../index.php?seccion=iniciar-sesion");
    exit;
}

$id                         = $_GET['id']; 
$nombre                     = $_POST['nombre'];
$detalle                   = $_POST['detalle'];
$descripcion                     = $_POST['descripcion'];
$estado_producto_fk      = $_POST['estado_producto_fk'];
$imagen_descripcion         = $_POST['imagen_descripcion'];
$etiquetas_fk               = $_POST['etiqueta_fk'] ?? [];
$imagen                     = $_FILES['imagen']; 
$precio                     = $_POST['precio'];


$errores = [];

// Título
if(empty($nombre)) {
    $errores['nombre'] = "El nombre debe tener un valor.";
} else if(strlen($nombre) < 3) { // strlen => string length
    $errores['nombre'] = "El nombre debe tener al menos 3 caracteres.";
}

// Sinopsis
if(empty($detalle)) {
    $errores['detalle'] = "Debe tener un detalle.";
}

// Cuerpo
if(empty($descripcion)) {
    $errores['descripcion'] = "La descripcion debe tener un valor.";
}

if(count($errores) > 0) {
    // Hay errores, así que debemos redireccionar al usuario de nuevo al form.
    $_SESSION['feedback-mensaje'] = "Algunos de los datos del formulario no cumplen con lo requerido. Por favor, corregí los errores y probá de nuevo.";
    $_SESSION['feedback-tipo'] = "error";

    // Guardamos los errores en una variable de sesión para que puedan mostrarse en el form.
    $_SESSION['errores'] = $errores;

    $_SESSION['data-vieja'] = $_POST;
    header('Location: ../index.php?seccion=productos-editar&id=' . $id);
    exit;
}

// 3. Subida de la imagen.
if(!empty($imagen['tmp_name'])) {
    $nombreImagen = date('Ymd_His_') . $imagen['name'];
    
    move_uploaded_file($imagen['tmp_name'], __DIR__ . '/../../imgs/' . $nombreImagen);
}


try {
    // Traemos la noticia actual que se está editando, para poder obtener los valores originales.
    $producto = (new Producto)->porId($id);

    // 4. Editar con la clase Noticia.
    (new Producto)->editar($id, [
        'estado_producto_fk' => $estado_producto_fk,
        'nombre' => $nombre,
        'detalle' => $detalle,
        'descripcion' => $descripcion,
        'imagen' => $nombreImagen ?? $producto->getImagen(), // Si no se creó una nueva imagen, mantenemos la actual.
        'imagen_descripcion' => $imagen_descripcion,
        'etiquetas_fk' => $etiquetas_fk,
        'precio' => $precio,
    ]);

    // 5. Redireccionar.
    $_SESSION['feedback-mensaje'] = "El producto se editó con éxito.";
    $_SESSION['feedback-tipo'] = "success";

    header('Location: ../index.php?seccion=productos');
    exit;
} 

catch (Exception $e) {
    // Si algo salió mal, lo devolvemos al usuario al formulario.
    $_SESSION['feedback-mensaje'] = "Ocurrió un error inesperado al tratar de editar el producto. Detalles: " . $e->getMessage();
    $_SESSION['feedback-tipo'] = "error";

    $_SESSION['data-vieja'] = $_POST;
    header('Location: ../index.php?seccion=productos-editar&id=' . $id);
    exit;
}


